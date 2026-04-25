<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin LaporIT',
            'email'    => 'admin@laporit.com',
            'password' => Hash::make('123456'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Operator IT',
            'email'    => 'operator@laporit.com',
            'password' => Hash::make('operator123'),
            'role'     => 'operator',
        ]);

        User::create([
            'name'     => 'User Biasa',
            'email'    => 'user@laporit.com',
            'password' => Hash::make('user12345'),
            'role'     => 'user',
        ]);
    }
}