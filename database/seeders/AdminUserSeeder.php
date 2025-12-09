<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'infoteknalogi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Sample Staff Users
        User::create([
            'name' => 'Staff 1',
            'email' => 'staff1@djokihub.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Staff 2',
            'email' => 'staff2@djokihub.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);
    }
}
