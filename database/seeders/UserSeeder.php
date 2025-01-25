<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tạo tài khoản admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin', // Đặt role là admin
        ]);

        // Tạo tài khoản customer
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => Hash::make('password123'),
            'role' => 'customer', // Đặt role là customer
        ]);

        // Tạo thêm một tài khoản admin nữa
        User::create([
            'name' => 'Admin 2',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
        
        // Tạo thêm một tài khoản customer nữa
        User::create([
            'name' => 'Customer 2',
            'email' => 'customer2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);
    }
}
