<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default user
        User::create([
            'last_name' => 'Default',
            'first_name' => 'User',
            'staff_id' => 'STAFF001',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'usertype' => 'staff',
            'current_team_id' => null,
            'profile_photo_path' => null,
            'remember_token' => null,
        ]);

        // Create default admin
        User::create([
            'last_name' => 'Admin',
            'first_name' => 'Default',
            'staff_id' => 'ADMIN001',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'usertype' => 'admin',
            'current_team_id' => null,
            'profile_photo_path' => null,
            'remember_token' => null,
        ]);
    }
}