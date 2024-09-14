<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Array of users to seed
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => 'admin', // Plain text password
                'is_admin' => true, // Admin user
            ],
            [
                'name' => 'user',
                'email' => 'user@user.com',
                'password' => 'user', // Plain text password
                'is_admin' => false, // Normal user
            ],
            // Add more users as needed
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']), // Hash the password
                'is_admin' => $user['is_admin'],
            ]);
        }
    }
}
