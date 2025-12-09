<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $user->load(['university', 'bank', 'assignedProjects' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(5);
        }]);

        if ($user->role === 'staff') {
             // Calculate leaderboard position
             $leaderboardPosition = \App\Models\User::where('role', 'staff')
                ->where(function($query) use ($user) {
                    $query->where('total_nett_budget', '>', $user->total_nett_budget)
                        ->orWhere(function($q) use ($user) {
                            $q->where('total_nett_budget', '=', $user->total_nett_budget)
                              ->where('total_claimed_projects', '>', $user->total_claimed_projects);
                        })
                        ->orWhere(function($q) use ($user) {
                             $q->where('total_nett_budget', '=', $user->total_nett_budget)
                              ->where('total_claimed_projects', '=', $user->total_claimed_projects)
                              ->where('name', '<', $user->name);
                        });
                })
                ->count() + 1;
        } else {
            $leaderboardPosition = null;
        }

        return view('profile.show', compact('user', 'leaderboardPosition'));
    }

    public function edit()
    {
        $user = auth()->user();
        $universities = \App\Models\University::orderBy('name')->get();
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
        
        return view('profile.edit', compact('user', 'universities', 'majors'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // 'email' validation removed as it is disabled in the view
            'phone' => 'nullable|string|max:20',
            'domisili' => 'nullable|string|max:255',
            'umur' => 'nullable|integer|min:1|max:150',
            'university_id' => 'nullable|exists:universities,id',
            'program_study' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_name' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        // Handle Photo Upload (Hostinger Shared Hosting Compatibility Mode)
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists (Manual check)
            if ($user->profile_photo) {
                // Check if it's the new assets path or old storage path
                $oldPath = public_path($user->profile_photo); // Assuming DB stores 'assets/...'
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            // Direct upload to public/assets/profile-photos
            $file = $request->file('profile_photo');
            $filename = $file->hashName();
            
            $destinationPath = public_path('assets/profile-photos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);

            // Save path matching standard Laravel asset() format
            $user->profile_photo = 'assets/profile-photos/' . $filename;
        }

        // Update basic info
        $user->fill([
            'name' => $validated['name'],
            // 'email' => $validated['email'], // Disabled
            'phone' => $validated['phone'] ?? null,
            'domisili' => $validated['domisili'] ?? null,
            'umur' => $validated['umur'] ?? null,
            'university_id' => $validated['university_id'] ?? null,
            'program_study' => $validated['program_study'] ?? null,
            // 'riwayat_pendidikan' is deprecated/replaced by univ+major
        ]);
        $user->save();

        // Update bank info (if staff)
        if ($user->isStaff()) {
            $user->update([
                'bank_name' => $validated['bank_name'] ?? null,
                'bank_account_number' => $validated['bank_account_number'] ?? null,
                'bank_account_name' => $validated['bank_account_name'] ?? null,
            ]);
        }

        // Update password if provided
        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully!');
    }

    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        auth()->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
