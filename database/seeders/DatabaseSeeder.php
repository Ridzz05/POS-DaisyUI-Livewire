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
        $admin = User::where('email', 'admin@filo.petshop.com')->first();

        if ($admin) {
            // Update existing admin password and role
            $admin->update([
                'password' => Hash::make('bona123'),
                'role' => 'Admin'
            ]);
        } else {
            // Create new admin user if doesn't exist
            User::create([
                'name' => 'Bona',
                'email' => 'admin@filo.petshop.com',
                'password' => Hash::make('bona123'),
                'role' => 'Admin'
            ]);
        }

        // Create a user with role "Kasir" if not already exists
        $kasir = User::where('email', 'kasir@filo.petshop.com')->first();

        if (!$kasir) {
            User::create([
                'name' => 'Kasir Fio',
                'email' => 'kasir@filo.petshop.com',
                'password' => Hash::make('kasir123'),
                'role' => 'Kasir'
            ]);
        }
    }
}
