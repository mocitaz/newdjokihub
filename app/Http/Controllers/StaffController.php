<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\University;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = User::where('role', 'staff')
            ->withCount([
                'assignedProjects as completed_projects_count' => function($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->orderBy('name', 'asc')
            ->paginate(15);

        // Self-Healing: Recalculate stats for displayed staff to ensure accuracy on page load
        foreach ($staff as $s) {
            $s->recalculateStats();
        }

        return view('staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $universities = University::orderBy('name')->get();
        $banks = Bank::where('is_active', true)->orderBy('name')->get();
        $majors = [
            'Administrasi Bisnis', 'Agribisnis', 'Agroteknologi', 'Akuntansi', 'Arsitektur', 
            'Biologi', 'Desain Komunikasi Visual', 'Desain Produk', 'Ekonomi Pembangunan', 
            'Farmasi', 'Fisika', 'Gizi', 'Hubungan Internasional', 'Hukum', 
            'Ilmu Komunikasi', 'Ilmu Komputer', 'Informatika', 
            'Kedokteran', 'Keguruan & Pendidikan', 'Keperawatan', 'Kesehatan Masyarakat', 
            'Kimia', 'Kriminologi', 'Manajemen', 'Matematika', 
            'Pendidikan Guru SD', 'Perencanaan Wilayah dan Kota', 'Psikologi', 
            'Sastra Indonesia', 'Sastra Inggris', 'Sastra Jepang', 'Seni Rupa', 
            'Sistem Informasi', 'Sosiologi', 'Statistika', 
            'Teknik Elektro', 'Teknik Industri', 'Teknik Informatika', 
            'Teknik Kimia', 'Teknik Lingkungan', 'Teknik Mesin', 'Teknik Sipil'
        ];
        sort($majors);
        $majors[] = 'Lainnya';
        return view('staff.create', compact('universities', 'banks', 'majors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'domisili' => 'nullable|string|max:255',
            'umur' => 'nullable|integer|min:1|max:150',
            'university_id' => 'required|exists:universities,id',
            'program_study' => 'nullable|string|max:255',
            'github' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bank_id' => 'nullable|exists:banks,id',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_name' => 'nullable|string|max:255',
        ]);

        // Get bank name from bank_id if provided
        $bankName = null;
        if (!empty($validated['bank_id'])) {
            $bank = Bank::find($validated['bank_id']);
            $bankName = $bank ? $bank->name : null;
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'staff',
            'phone' => $validated['phone'] ?? null,
            'domisili' => $validated['domisili'] ?? null,
            'umur' => $validated['umur'] ?? null,
            'university_id' => $validated['university_id'],
            'program_study' => $validated['program_study'] ?? null,
            'github' => $validated['github'] ?? null,
            'linkedin' => $validated['linkedin'] ?? null,
            'bank_id' => $validated['bank_id'] ?? null,
            'bank_name' => $bankName,
            'bank_account_number' => $validated['bank_account_number'] ?? null,
            'bank_account_name' => $validated['bank_account_name'] ?? null,
        ];

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->hashName();
            
            $destinationPath = public_path('assets/profile-photos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data['profile_photo'] = 'assets/profile-photos/' . $filename;
        }

        User::create($data);

        return redirect()->route('staff.index')
            ->with('success', 'Staff created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $staff)
    {
        // Ensure it's a staff member
        if ($staff->role !== 'staff') {
            abort(404);
        }

        $staff->load([
            'university',
            'bank',
            'assignedProjects' => function($query) {
                $query->orderBy('created_at', 'desc');
            },
            'claimLogs' => function($query) {
                $query->orderBy('created_at', 'desc')->limit(10);
            }
        ]);

        // Self-Healing: Ensure stats are up to date
        $staff->recalculateStats();

        // Calculate leaderboard position
        $leaderboardPosition = User::where('role', 'staff')
            ->where(function($query) use ($staff) {
                $query->where('total_nett_budget', '>', $staff->total_nett_budget)
                    ->orWhere(function($q) use ($staff) {
                        $q->where('total_nett_budget', '=', $staff->total_nett_budget)
                          ->where('total_claimed_projects', '>', $staff->total_claimed_projects);
                    });
            })
            ->count() + 1;

        return view('staff.show', compact('staff', 'leaderboardPosition'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $staff)
    {
        if ($staff->role !== 'staff') {
            abort(404);
        }

        $universities = University::orderBy('name')->get();
        $banks = Bank::where('is_active', true)->orderBy('name')->get();
        $majors = [
            'Administrasi Bisnis', 'Agribisnis', 'Agroteknologi', 'Akuntansi', 'Arsitektur', 
            'Biologi', 'Desain Komunikasi Visual', 'Desain Produk', 'Ekonomi Pembangunan', 
            'Farmasi', 'Fisika', 'Gizi', 'Hubungan Internasional', 'Hukum', 
            'Ilmu Komunikasi', 'Ilmu Komputer', 'Informatika', 
            'Kedokteran', 'Keguruan & Pendidikan', 'Keperawatan', 'Kesehatan Masyarakat', 
            'Kimia', 'Kriminologi', 'Manajemen', 'Matematika', 
            'Pendidikan Guru SD', 'Perencanaan Wilayah dan Kota', 'Psikologi', 
            'Sastra Indonesia', 'Sastra Inggris', 'Sastra Jepang', 'Seni Rupa', 
            'Sistem Informasi', 'Sosiologi', 'Statistika', 
            'Teknik Elektro', 'Teknik Industri', 'Teknik Informatika', 
            'Teknik Kimia', 'Teknik Lingkungan', 'Teknik Mesin', 'Teknik Sipil'
        ];
        sort($majors);
        $majors[] = 'Lainnya';
        return view('staff.edit', compact('staff', 'universities', 'banks', 'majors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $staff)
    {
        if ($staff->role !== 'staff') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($staff->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'domisili' => 'nullable|string|max:255',
            'umur' => 'nullable|integer|min:1|max:150',
            'university_id' => 'required|exists:universities,id',
            'program_study' => 'nullable|string|max:255',
            'github' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bank_id' => 'nullable|exists:banks,id',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_name' => 'nullable|string|max:255',
        ]);

        // Get bank name from bank_id if provided
        $bankName = null;
        if (!empty($validated['bank_id'])) {
            $bank = Bank::find($validated['bank_id']);
            $bankName = $bank ? $bank->name : null;
        }

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'domisili' => $validated['domisili'] ?? null,
            'umur' => $validated['umur'] ?? null,
            'university_id' => $validated['university_id'],
            'program_study' => $validated['program_study'] ?? null,
            'github' => $validated['github'] ?? null,
            'linkedin' => $validated['linkedin'] ?? null,
            'bank_id' => $validated['bank_id'] ?? null,
            'bank_name' => $bankName,
            'bank_account_number' => $validated['bank_account_number'] ?? null,
            'bank_account_name' => $validated['bank_account_name'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($staff->profile_photo) {
                $oldPath = public_path($staff->profile_photo);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
            
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->hashName();
            
            $destinationPath = public_path('assets/profile-photos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $updateData['profile_photo'] = 'assets/profile-photos/' . $filename;
        }

        $staff->update($updateData);

        return redirect()->route('staff.show', $staff)
            ->with('success', 'Staff updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $staff)
    {
        if ($staff->role !== 'staff') {
            abort(404);
        }

        // Delete profile photo if exists
        if ($staff->profile_photo && file_exists(public_path($staff->profile_photo))) {
             @unlink(public_path($staff->profile_photo));
        }

        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Staff deleted successfully!');
    }
}
