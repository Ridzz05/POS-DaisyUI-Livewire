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
        // Check if admin user exists
        $admin = User::where('email', 'admin@example.com')->first();

        if ($admin) {
            // Update existing admin password
            $admin->update([
                'password' => Hash::make('password')
            ]);
        } else {
            // Create new admin user if doesn't exist
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password')
            ]);
        }
    }
}