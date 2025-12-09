<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProjectStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create admin user
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'infoteknalogi@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        // Create 10 Staff Users
        $staffNames = [
            'Ahmad Rizki', 'Budi Santoso', 'Citra Dewi', 'Dedi Pratama',
            'Eka Sari', 'Fajar Nugroho', 'Gita Permata', 'Hadi Wijaya',
            'Indah Lestari', 'Joko Susilo'
        ];

        $staffUsers = [];
        for ($i = 0; $i < 10; $i++) {
            $staffUsers[] = User::create([
                'name' => $staffNames[$i],
                'email' => strtolower(str_replace(' ', '', $staffNames[$i])) . '@djokihub.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '08' . rand(1000000000, 9999999999),
                'domisili' => ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Medan'][rand(0, 4)],
                'umur' => rand(25, 45),
                'riwayat_pendidikan' => 'S1 Teknik Informatika - Universitas ' . ['Indonesia', 'Gadjah Mada', 'Brawijaya', 'Diponegoro'][rand(0, 3)] . ' (' . rand(2010, 2020) . ')',
                'bank_name' => ['BCA', 'Mandiri', 'BNI', 'BRI'][rand(0, 3)],
                'bank_account_number' => rand(1000000000, 9999999999),
                'bank_account_name' => $staffNames[$i],
            ]);
        }

        // Project names
        $projectNames = [
            'Website E-Commerce Toko Online',
            'Aplikasi Mobile Banking',
            'Sistem Manajemen Inventory',
            'Platform E-Learning',
            'Dashboard Analytics Real-time',
            'API Gateway Microservices',
            'Sistem CRM Perusahaan',
            'Aplikasi Food Delivery',
            'Platform Social Media',
            'Sistem ERP Manufacturing',
            'Website Company Profile',
            'Aplikasi Fitness Tracker',
            'Sistem Booking Hotel',
            'Platform Crowdfunding',
            'Aplikasi Travel Planner',
            'Sistem Manajemen Proyek',
            'Website News Portal',
            'Aplikasi Health Monitoring',
            'Platform Marketplace',
            'Sistem HR Management',
        ];

        // Create 20 Projects
        $statuses = ['available', 'in_progress', 'completed', 'cancelled'];
        $statusWeights = [4, 3, 2, 1]; // More available and in_progress projects

        /*
        for ($i = 0; $i < 20; $i++) {
            // Random status with weights
            $statusIndex = $this->weightedRandom($statusWeights);
            $status = $statuses[$statusIndex];

            // Budget between 10M - 500M
            $budget = rand(10000000, 500000000);
            
            // Admin fee percentage between 5% - 15%
            $adminFeePercentage = rand(500, 1500) / 100;
            $adminFee = ($budget * $adminFeePercentage) / 100;
            $nettBudget = $budget - $adminFee;

            // Assign staff randomly (70% chance if in_progress or completed)
            $assignedTo = null;
            $claimedAt = null;
            
            if (in_array($status, ['in_progress', 'completed']) && rand(1, 10) <= 7) {
                $assignedTo = $staffUsers[rand(0, 9)]->id;
                // Claimed at random time between created_at and now
                $createdAt = Carbon::now()->subDays(rand(1, 60));
                $claimedAt = $createdAt->copy()->addHours(rand(1, 48));
            }

            // Dates
            $startDate = Carbon::now()->subDays(rand(0, 90));
            $endDate = $startDate->copy()->addDays(rand(30, 180));

            // If completed, end date should be in the past
            if ($status === 'completed') {
                $endDate = Carbon::now()->subDays(rand(1, 30));
                $startDate = $endDate->copy()->subDays(rand(30, 120));
            }

            // If cancelled, set end date to null or past
            if ($status === 'cancelled') {
                $endDate = $startDate->copy()->addDays(rand(1, 30));
            }

            $project = Project::create([
                'order_id' => 'PRJ-' . strtoupper(Str::random(8)),
                'name' => $projectNames[$i],
                'description' => 'Deskripsi lengkap untuk proyek ' . $projectNames[$i] . '. Proyek ini mencakup pengembangan fitur-fitur utama dan integrasi dengan sistem yang ada.',
                'budget' => $budget,
                'admin_fee_percentage' => $adminFeePercentage,
                'admin_fee' => $adminFee,
                'nett_budget' => $nettBudget,
                'status' => $status,
                'assigned_to' => $assignedTo,
                'created_by' => $admin->id,
                'claimed_at' => $claimedAt,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'notes' => rand(0, 1) ? 'Catatan tambahan untuk proyek ini.' : null,
            ]);

            // Update timestamps to make it more realistic
            $createdAt = Carbon::now()->subDays(rand(1, 90));
            $project->created_at = $createdAt;
            $project->updated_at = Carbon::now()->subDays(rand(0, 30));
            $project->save();
        }
        */

        // Update staff metrics based on assigned projects
        foreach ($staffUsers as $staff) {
            $assignedProjects = Project::where('assigned_to', $staff->id)->get();
            $completedProjects = $assignedProjects->where('status', 'completed');
            
            $staff->update([
                'total_claimed_projects' => $assignedProjects->count(),
                'total_nett_budget' => $completedProjects->sum('nett_budget'),
            ]);
        }
    }

    /**
     * Weighted random selection
     */
    private function weightedRandom(array $weights): int
    {
        $total = array_sum($weights);
        $random = rand(1, $total);
        $current = 0;
        
        foreach ($weights as $index => $weight) {
            $current += $weight;
            if ($random <= $current) {
                return $index;
            }
        }
        
        return 0;
    }
}

