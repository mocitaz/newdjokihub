<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'domisili',
        'umur',
        'riwayat_pendidikan',
        'university_id',
        'program_study',
        'github',
        'linkedin',
        'profile_photo',
        'bank_id',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'total_claims',
        'total_claimed_projects',
        'total_nett_budget',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'total_nett_budget' => 'decimal:2',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is staff
     */
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    /**
     * Recalculate user statistics (claimed projects and total earnings).
     */
    public function recalculateStats()
    {
        $completedProjects = $this->assignedProjects()
            ->where('status', 'completed')
            ->get();
        
        $totalClaims = $this->claimLogs()->where('success', true)->count();
        
        // If claims < completed (e.g. direct assignments without claims), use completed count as min claims
        if ($totalClaims < $completedProjects->count()) {
            $totalClaims = $completedProjects->count();
        }

        $this->update([
            'total_claims' => $totalClaims,
            'total_claimed_projects' => $completedProjects->count(),
            'total_nett_budget' => $completedProjects->sum('pivot.payout_amount')
        ]);
    }

    /**
     * Get projects assigned to this user
     */
    public function assignedProjects(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_user')->withPivot('payout_amount')->withTimestamps();
    }

    /**
     * Get projects created by this user
     */
    public function createdProjects()
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    /**
     * Get claim logs for this user
     */
    public function claimLogs()
    {
        return $this->hasMany(ClaimLog::class);
    }

    /**
     * Get notifications for this user
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get unread notifications count
     */
    public function unreadNotificationsCount(): int
    {
        return $this->notifications()->where('read', false)->count();
    }

    /**
     * Calculate claim success rate
     */
    public function getClaimSuccessRateAttribute(): float
    {
        $completed = $this->total_claimed_projects;
        $claims = $this->total_claims;

        // If no activity at all, 0%
        if ($claims == 0 && $completed == 0) {
            return 0;
        }

        // If claims are 0 but has completed projects (e.g. direct assignment), consider it 100% success
        if ($claims == 0) {
            return 100;
        }

        // Calculate rate
        $rate = ($completed / $claims) * 100;

        // Cap at 100% to ensure it never exceeds standard metrics
        return min($rate, 100);
    }

    /**
     * Get the university
     */
    public function university()
    {
        return $this->belongsTo(University::class);
    }

    /**
     * Get the bank
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    /**
     * Get profile photo URL with default fallback
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->profile_photo)) {
            return \Illuminate\Support\Facades\Storage::url($this->profile_photo);
        }
        
        // Default profile image path
        $defaultPath = 'images/default-profile.png';
        if (file_exists(public_path($defaultPath))) {
            return asset($defaultPath);
        }
        
        // Fallback to storage if not in public
        $defaultStoragePath = 'default-profile.png';
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($defaultStoragePath)) {
            return \Illuminate\Support\Facades\Storage::url($defaultStoragePath);
        }
        
        // Return empty string if no default found (will use initial fallback in view)
        return '';
    }
}
