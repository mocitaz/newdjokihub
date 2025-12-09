<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Project;
use App\Models\ClaimLog;
use App\Models\Notification;
use App\Mail\ProjectClaimedMail;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

use Livewire\Attributes\On;

class ClaimCenterList extends Component
{
    use LogsActivity;

    public $projects = [];

    public function mount()
    {
        $this->loadProjects();
    }

    #[On('refresh-projects')] 
    public function refresh() 
    {
        $this->loadProjects();
    }

    public function loadProjects()
    {
        $this->projects = Project::where('status', 'available')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    public function claimProject($projectId)
    {
        // Only staff can claim
        if (!auth()->user()->isStaff()) {
            $this->dispatch('claim-error', message: 'Hanya staff yang dapat meng-claim proyek!');
            return;
        }

        // Use database transaction to prevent race condition
        try {
            DB::beginTransaction();

            // Lock the project row
            $project = Project::where('id', $projectId)
                ->where('status', 'available')
                ->lockForUpdate()
                ->first();

            if (!$project) {
                DB::rollBack();
                $this->dispatch('claim-error', message: 'TERLAMBAT! Sudah di-claim Staf lain.');
                return;
            }

            // Calculate claim duration
            $claimDuration = $project->created_at->diffInSeconds(Carbon::now());

            // Update project
            $project->update([
                'status' => 'in_progress',
                'assigned_to' => auth()->id(),
                'claimed_at' => Carbon::now(),
            ]);

            // Update user stats
            $user = auth()->user();
            $user->increment('total_claims');
            // total_claimed_projects and total_nett_budget will be updated upon completion

            // Create claim log
            ClaimLog::create([
                'project_id' => $project->id,
                'user_id' => auth()->id(),
                'success' => true,
                'message' => 'Successfully claimed',
                'claim_duration_seconds' => $claimDuration,
                'attempted_at' => Carbon::now(),
            ]);

            // Log activity
            $this->logActivity('claimed', $project);

            // Create success notification
            Notification::create([
                'user_id' => auth()->id(),
                'type' => 'claim_success',
                'title' => 'Project Claimed Successfully!',
                'message' => "You have successfully claimed project: {$project->name} (Order: {$project->order_id})",
                'project_id' => $project->id,
            ]);

            // Notify Admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'type' => 'claim_alert',
                    'title' => 'Project Claimed Alert',
                    'message' => "Staff {$user->name} has claimed project: {$project->name}",
                    'project_id' => $project->id,
                ]);
            }

            // Send email notification
            try {
                Mail::to(auth()->user()->email)->send(new ProjectClaimedMail($project));
            } catch (\Exception $e) {
                \Log::error('Failed to send claim email: ' . $e->getMessage());
            }

            DB::commit();

            // Reload projects
            $this->loadProjects();

            // Dispatch success event
            $this->dispatch('claim-success', message: 'Proyek berhasil di-claim!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log failed attempt
            ClaimLog::create([
                'project_id' => $projectId,
                'user_id' => auth()->id(),
                'success' => false,
                'message' => 'Failed to claim: ' . $e->getMessage(),
                'attempted_at' => Carbon::now(),
            ]);

            $this->dispatch('claim-error', message: 'Gagal meng-claim proyek. Silakan coba lagi.');
        }
    }

    public function render()
    {
        return view('livewire.claim-center-list');
    }
}
