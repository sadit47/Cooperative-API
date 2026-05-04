<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'public@test.com'],
            [
                'name' => 'Public User',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'public',
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@test.com'],
            [
                'name' => 'Staff User',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );
    }
}