<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@test.com',
            'password' => Hash::make('12345678'),
            'status' => true,
        ]);

        $user->assignRole('super-admin');

        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => '',
            'username' => 'admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'),
            'status' => true,
        ]);

        $user->assignRole('admin');
    }
}
