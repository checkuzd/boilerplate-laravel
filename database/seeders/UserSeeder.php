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
        $user = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@test.com',
            'password' => Hash::make('12345678'),
            'status' => true,
        ]);
        $role = Role::create(['name' => 'super-admin', 'title' => 'Super Admin']);
        $user->assignRole($role);

        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => '',
            'username' => 'admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'),
            'status' => true,
        ]);
        $role = Role::create(['name' => 'admin', 'title' => 'Admin']);
        $user->assignRole($role);

        $user = User::create([
            'first_name' => 'User',
            'last_name' => '',
            'username' => 'user',
            'email' => 'user@test.com',
            'password' => Hash::make('12345678'),
            'status' => true,
        ]);
        $role = Role::create(['name' => 'user', 'title' => 'User']);
        $user->assignRole($role);
    }
}
