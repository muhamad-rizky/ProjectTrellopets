<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'adminpet@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);
        User::create([
            'name' => 'Kasir',
            'email' => 'kasirpet@gmail.com',
            'role' => 'kasir',
            'password' => Hash::make('kasir123'),
        ]);
    }
}
