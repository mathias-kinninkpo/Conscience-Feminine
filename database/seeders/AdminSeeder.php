<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Your migration creates the 'users' table

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert an admin user into the users table.
        // Note: The provided migration doesn't have a role column.
        // If you plan to have multiple roles, consider updating the migration to include a 'role' field.
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@example.com',
            'password' => Hash::make('your_secure_password'), // Replace with a secure password
        ]);
    }
}
