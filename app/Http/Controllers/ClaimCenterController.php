<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Project;
use App\Models\ClaimLog;
use App\Models\Notification;
use App\Mail\ProjectClaimedMail;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ClaimCenterController extends Controller
{
    use LogsActivity;
    public function index()
    {
        // Admin and Staff can view claim center (Admin for monitoring)
        $projects = Project::where('status', 'available')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('claim-center.index', compact('projects'));
    }

    public function show(Project $project)
    {
        // Ensure project is available
        if ($project->status !== 'available') {
            return redirect()->route('claim-center.index')
                ->with('error', 'Project is no longer available.');
        }

        return view('claim-center.show', compact('project'));
    }

    public function claim(Project $project)
    {
        // Only staff can claim
        if (!auth()->user()->isStaff()) {
            return response()->json(['success' => false, 'message' => 'Only staff can claim projects'], 403);
        }

        // Check if project is still available
        if ($project->status !== 'available') {
            return response()->json([
                'success' => false, 
                'message' => 'TERLAMBAT! Sudah di-claim Staf lain.'
            ], 400);
        }

        // Use database transaction to prevent race condition
        try {
            DB::beginTransaction();

            // Lock the project row
            $lockedProject = Project::where('id', $project->id)
                ->where('status', 'available')
                ->lockForUpdate()
                ->first();

            if (!$lockedProject) {
                DB::rollBack();
                return response()->json([
                    'success' => false, 
                    'message' => 'TERLAMBAT! Sudah di-claim Staf lain.'
                ], 400);
            }

            // Calculate claim duration
            $claimDuration = $lockedProject->created_at->diffInSeconds(Carbon::now());

            // Update project
            // Update project status
            $lockedProject->update([
                'status' => 'in_progress',
                'claimed_at' => Carbon::now(),
            ]);
            
            // Assign user and set full payout (since they are the first/sole claimer)
            $lockedProject->assignees()->attach(auth()->id(), [
                'payout_amount' => $lockedProject->nett_budget
            ]);

            // Update user stats
            $user = auth()->user();
            $user->recalculateStats();

            // Create claim log
            ClaimLog::create([
                'project_id' => $lockedProject->id,
                'user_id' => auth()->id(),
                'success' => true,
                'message' => 'Successfully claimed',
                'claim_duration_seconds' => $claimDuration,
                'attempted_at' => Carbon::now(),
            ]);

            // Log activity
            $this->logActivity('claimed', $lockedProject);

            // Create success notification
            Notification::create([
                'user_id' => auth()->id(),
                'type' => 'claim_success',
                'title' => 'Project Claimed Successfully!',
                'message' => "You have successfully claimed project: {$lockedProject->name} (Order: {$lockedProject->order_id})",
                'project_id' => $lockedProject->id,
            ]);

            // Notify Admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'type' => 'claim_alert',
                    'title' => 'Project Claimed Alert',
                    'message' => "Staff {$user->name} has claimed project: {$lockedProject->name}",
                    'project_id' => $lockedProject->id,
                ]);
            }

            // Send email notification
            try {
                Mail::to(auth()->user()->email)->send(new ProjectClaimedMail($lockedProject));
            } catch (\Exception $e) {
                // Log error but don't fail the claim
                \Log::error('Failed to send claim email: ' . $e->getMessage());
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Project claimed successfully!',
                'project_id' => $lockedProject->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log failed attempt
            ClaimLog::create([
                'project_id' => $project->id,
                'user_id' => auth()->id(),
                'success' => false,
                'message' => 'Failed to claim: ' . $e->getMessage(),
                'attempted_at' => Carbon::now(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to claim project. Please try again.'
            ], 500);
        }
    }
}
