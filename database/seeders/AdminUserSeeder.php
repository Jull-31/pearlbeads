<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat admin user
        User::create([
            'name' => 'Admin Pearlbeads',
            'email' => 'admin@pearlbeads.co',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);

        // Buat user biasa untuk testing
        User::create([
            'name' => 'Customer Test',
            'email' => 'customer@test.com',
            'password' => Hash::make('customer123'),
            'is_admin' => false,
        ]);
    }
}