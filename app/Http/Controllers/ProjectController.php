<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Deliverable;
use App\Models\User;
use App\Models\Notification;
use App\Exports\ProjectsExport;
use App\Mail\ProjectAssignedMail;
use App\Mail\NewProjectAvailableMail;
use App\Mail\ProjectCompletedMail;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
    use LogsActivity;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projects = Project::with(['assignees', 'creator'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('projects.index', compact('projects'));
    }

    /**
     * Export projects to Excel
     */
    public function export(Request $request)
    {
        $projects = Project::with(['assignees', 'creator'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Excel::download(new ProjectsExport($projects), 'projects-' . now()->format('Y-m-d') . '.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $staff = User::where('role', 'staff')->orderBy('name', 'asc')->get();
        return view('projects.create', compact('staff'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'order_id' => 'nullable|string|max:255|unique:projects,order_id',
            'description' => 'nullable|string',
            'budget' => 'required|numeric|min:0',
            'admin_fee_percentage' => 'required|numeric|min:0|max:100',
            'assigned_to' => 'nullable|array', // Changed to array
            'assigned_to.*' => 'exists:users,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
            'deliverables' => 'nullable|array',
            'deliverables.*.name' => 'required|string|max:255',
            'deliverables.*.description' => 'nullable|string',
            'github_url' => 'nullable|url',
            'google_drive_url' => 'nullable|url',
        ]);

        // Calculate admin fee and nett budget
        $adminFee = ($validated['budget'] * $validated['admin_fee_percentage']) / 100;
        $nettBudget = $validated['budget'] - $adminFee;

        // Generate order_id if not provided
        if (empty($validated['order_id'])) {
            $lastOrder = Project::where('order_id', 'like', 'DC-%')
                ->get()
                ->map(function ($p) {
                    return (int) substr($p->order_id, 3);
                })
                ->max();

            $nextNumber = $lastOrder ? max($lastOrder, config('app.project_start_index')) + 1 : (config('app.project_start_index') + 1);
            $validated['order_id'] = 'DC-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        // Determine status based on assignment
        $status = !empty($validated['assigned_to']) ? 'in_progress' : 'available';

        $project = Project::create([
            'order_id' => $validated['order_id'],
            'name' => $validated['name'],
            'client_name' => $validated['client_name'] ?? null,
            'description' => $validated['description'] ?? null,
            'budget' => $validated['budget'],
            'admin_fee_percentage' => $validated['admin_fee_percentage'],
            'admin_fee' => $adminFee,
            'nett_budget' => $nettBudget,
            'status' => $status,
            // 'assigned_to' removed
            'created_by' => auth()->id(),
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'github_url' => $validated['github_url'] ?? null,
            'google_drive_url' => $validated['google_drive_url'] ?? null,
        ]);

        // Attach Users and Recalculate
        if (!empty($validated['assigned_to'])) {
            $project->assignees()->attach($validated['assigned_to']);
            $project->recalculatePayouts();

            foreach ($validated['assigned_to'] as $userId) {
                $assignedUser = User::find($userId);
                if ($assignedUser) {
                    Notification::create([
                        'user_id' => $assignedUser->id,
                        'type' => 'project_assigned',
                        'title' => 'New Project Assigned',
                        'message' => "You have been assigned to project: {$project->name} (Order: {$project->order_id})",
                        'project_id' => $project->id,
                    ]);

                    // Send email notification (Direct send for reliability)
                    try {
                        Mail::to($assignedUser->email)->send(new ProjectAssignedMail($project));
                    } catch (\Exception $e) {
                         \Log::error('Failed to send assignment email: ' . $e->getMessage());
                    }
                }
            }
        } else {
            // Project is available (Unassigned) -> Notify all Staff
            $allStaff = User::where('role', 'staff')->get();
            foreach ($allStaff as $staff) {
                try {
                    Mail::to($staff->email)->send(new NewProjectAvailableMail($project));
                } catch (\Exception $e) {
                    // Log but continue
                    \Log::error('Failed to send avail project email to ' . $staff->email . ': ' . $e->getMessage());
                }
            }
        }

        // Log activity
        $this->logActivity('created', $project);

        // Create Deliverables
        if (!empty($validated['deliverables'])) {
            foreach ($validated['deliverables'] as $index => $item) {
                $project->deliverables()->create([
                    'name' => $item['name'],
                    'description' => $item['description'] ?? null,
                    'order' => $index + 1,
                    'is_completed' => false,
                ]);
            }
        }

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['assignees', 'creator', 'claimLogs.user', 'deliverables']);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $staff = User::where('role', 'staff')->orderBy('name', 'asc')->get();
        return view('projects.edit', compact('project', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'order_id' => ['nullable', 'string', 'max:255', Rule::unique('projects')->ignore($project->id)],
            'description' => 'nullable|string',
            'budget' => 'required|numeric|min:0',
            'admin_fee_percentage' => 'required|numeric|min:0|max:100',
            'assigned_to' => 'nullable|array',
            'assigned_to.*' => 'exists:users,id',
            'status' => 'required|in:available,in_progress,completed,cancelled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
            'deliverables' => 'nullable|array',
            'deliverables.*.id' => 'nullable|exists:deliverables,id',
            'deliverables.*.name' => 'required|string|max:255',
            'deliverables.*.description' => 'nullable|string',
            'deliverables.*.is_completed' => 'nullable|boolean',
            'deleted_deliverables' => 'nullable|string',
            'github_url' => 'nullable|url',
            'google_drive_url' => 'nullable|url',
        ]);

        // Calculate admin fee and nett budget
        $adminFee = ($validated['budget'] * $validated['admin_fee_percentage']) / 100;
        $nettBudget = $validated['budget'] - $adminFee;

        // Store old values for logging
        $oldValues = $project->toArray();

        $project->update([
            'name' => $validated['name'],
            'client_name' => $validated['client_name'] ?? null,
            'order_id' => $validated['order_id'] ?? $project->order_id,
            'description' => $validated['description'] ?? null,
            'budget' => $validated['budget'],
            'admin_fee_percentage' => $validated['admin_fee_percentage'],
            'admin_fee' => $adminFee,
            'nett_budget' => $nettBudget,
            'status' => $validated['status'],
            // 'assigned_to' removed from update
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'github_url' => $validated['github_url'] ?? null,
            'google_drive_url' => $validated['google_drive_url'] ?? null,
        ]);
        
        // Sync Assignees
        $oldAssignees = $project->assignees->pluck('id')->toArray();
        $project->assignees()->sync($validated['assigned_to'] ?? []);
        $project->recalculatePayouts();

        // Sync stats for all involved users (old and new)
        // This ensures if a user was removed from a completed project, or added to one,
        // or if budget changed, their stats are updated.
        $newAssignees = $validated['assigned_to'] ?? [];
        $involvedUsers = array_unique(array_merge($oldAssignees, $newAssignees));
        
        if (!empty($involvedUsers)) {
             $usersToSync = User::whereIn('id', $involvedUsers)->get();
             foreach ($usersToSync as $user) {
                 $user->recalculateStats();
             }
        }

        // Log activity
        $this->logActivity('updated', $project, $oldValues, $project->fresh()->toArray());

        // Handle Deliverables
        
        // 1. Delete removed items
        if (!empty($request->deleted_deliverables)) {
            $deletedIds = explode(',', $request->deleted_deliverables);
            $project->deliverables()->whereIn('id', $deletedIds)->delete();
        }

        // 2. Upsert items
        if (!empty($validated['deliverables'])) {
            foreach ($validated['deliverables'] as $index => $item) {
                if (isset($item['id']) && $item['id']) {
                    // Update existing
                    $project->deliverables()->where('id', $item['id'])->update([
                        'name' => $item['name'],
                        'description' => $item['description'] ?? null,
                        'order' => $index + 1,
                        'is_completed' => isset($item['is_completed']) ? (bool)$item['is_completed'] : false,
                    ]);
                } else {
                    // Create new
                    $project->deliverables()->create([
                        'name' => $item['name'],
                        'description' => $item['description'] ?? null,
                        'order' => $index + 1,
                        'is_completed' => isset($item['is_completed']) ? (bool)$item['is_completed'] : false,
                    ]);
                }
            }
        }

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Log activity before deletion
        $this->logActivity('deleted', $project);
        
        $project->delete();
        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully!');
    }

    /**
     * Generate Invoice PDF
     */
    public function generateInvoice(Project $project)
    {
        $project->load(['assignees', 'creator', 'deliverables']);
        
        $pdf = Pdf::loadView('pdf.invoice', compact('project'));
        return $pdf->download('Invoice-' . $project->order_id . '.pdf');
    }

    /**
     * Generate BAST PDF
     */
    public function generateBast(Project $project)
    {
        $project->load(['assignees', 'creator', 'deliverables']);
        
        $pdf = Pdf::loadView('pdf.bast', compact('project'));
        return $pdf->download('BAST-' . $project->order_id . '.pdf');
    }

    /**
     * Generate POC PDF
     */
    public function generatePoc(Project $project)
    {
        $project->load(['assignees', 'creator', 'deliverables']);
        
        $pdf = Pdf::loadView('pdf.poc', compact('project'));
        return $pdf->download('POC-' . $project->order_id . '.pdf');
    }

    /**
     * Store deliverable for a project
     */
    public function storeDeliverable(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $maxOrder = $project->deliverables()->max('order') ?? 0;

        $deliverable = $project->deliverables()->create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'order' => $maxOrder + 1,
            'is_completed' => false,
        ]);

        return response()->json([
            'success' => true,
            'deliverable' => $deliverable,
        ]);
    }

    /**
     * Update deliverable
     */
    public function updateDeliverable(Request $request, Project $project, Deliverable $deliverable)
    {
        // Ensure deliverable belongs to project
        if ($deliverable->project_id !== $project->id) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $deliverable->update($validated);

        return response()->json([
            'success' => true,
            'deliverable' => $deliverable->fresh(),
        ]);
    }

    /**
     * Toggle deliverable completion status
     */
    public function toggleDeliverable(Project $project, Deliverable $deliverable)
    {
        // Ensure deliverable belongs to project
        if ($deliverable->project_id !== $project->id) {
            abort(404);
        }

        $deliverable->update([
            'is_completed' => !$deliverable->is_completed,
        ]);

        return response()->json([
            'success' => true,
            'deliverable' => $deliverable->fresh(),
        ]);
    }

    /**
     * Delete deliverable
     */
    public function deleteDeliverable(Project $project, Deliverable $deliverable)
    {
        // Ensure deliverable belongs to project
        if ($deliverable->project_id !== $project->id) {
            abort(404);
        }

        $deliverable->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Mark project as completed
     */
    public function complete(Project $project)
    {
        if ($project->status === 'completed') {
            return redirect()->route('projects.show', $project)
                ->with('error', 'Project is already completed.');
        }

        $oldStatus = $project->status;
        $project->update(['status' => 'completed']);

        // Log activity
        $this->logActivity('completed', $project, ['status' => $oldStatus], ['status' => 'completed']);

        // Update User Stats (handled by command or simple increment here if single user, but for multi we rely on batch sync or inline loop)
        // Inline loop for immediate feedback:
        foreach ($project->assignees as $user) {
             $user->increment('total_claimed_projects');
             $user->increment('total_nett_budget', $user->pivot->payout_amount);
        }

        // Create notification for assigned staff
        foreach ($project->assignees as $user) {
             Notification::create([
                'user_id' => $user->id,
                'type' => 'project_completed',
                'title' => 'Project Completed',
                'message' => "Project '{$project->name}' has been marked as completed.",
                'project_id' => $project->id,
            ]);

            // Send Completion Email
            try {
                Mail::to($user->email)->send(new ProjectCompletedMail($project));
            } catch (\Exception $e) {
                \Log::error('Failed to send completion email: ' . $e->getMessage());
            }
        }

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project marked as completed!');
    }

    /**
     * Mark project as cancelled
     */
    public function cancel(Project $project)
    {
        if ($project->status === 'cancelled') {
            return redirect()->route('projects.show', $project)
                ->with('error', 'Project is already cancelled.');
        }

        $oldStatus = $project->status;
        $project->update(['status' => 'cancelled']);

        // Log activity
        $this->logActivity('cancelled', $project, ['status' => $oldStatus], ['status' => 'cancelled']);

        // Create notification for assigned staff
        foreach ($project->assignees as $user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => 'project_cancelled',
                'title' => 'Project Cancelled',
                'message' => "Project '{$project->name}' has been cancelled.",
                'project_id' => $project->id,
            ]);

            // Recalculate stats for the user
            $user->recalculateStats();
        }

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project has been cancelled.');
    }
}
