<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin' => 'admin',
            'customer' => 'customer',
        ];

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

        $user->assignRole($roles['admin']);

        $user = User::create([
            'first_name' => 'Customer',
            'last_name' => '',
            'username' => 'customer',
            'email' => 'customer@test.com',
            'password' => Hash::make('12345678'),
            'status' => true,
        ]);

        $user->assignRole($roles['customer']);

        foreach ($roles as $key => $role) {
            User::factory()
                ->withRole($role)
                ->count(100)
                ->create();
        }

    }
}
