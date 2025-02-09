<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Loop to create 15 users
        for ($i = 0; $i < 20; $i++) {
            User::create([
                'name' => 'Admin ' . ($i + 1), // Names from 'Admin 1' to 'Admin 15'
                'email' => 'admin' . ($i + 1) . '@example.com', // Email: admin1@example.com to admin15@example.com
                'phone' => '01000000' . str_pad($i + 1, 2, '0', STR_PAD_LEFT), // Phone: 0100000001 to 0100000015
                'password' => Hash::make('admin12345'), // Same password for all users
            ]);
        }
    }
}
