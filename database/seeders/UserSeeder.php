<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'), // Use Hash::make() for security
            'role' => 'manager',
        ]);

        User::firstOrCreate([
            'name' => 'john',
            'email' => 'john@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('john'), // Use Hash::make() for security
            'role' => 'staff',
        ]);
    }
}
