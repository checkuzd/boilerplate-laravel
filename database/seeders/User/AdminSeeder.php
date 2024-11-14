<?php

declare(strict_types=1);

namespace Database\Seeders\User;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@test.com',
            'password' => '12345678',
            'status' => true,
        ]);

        $user->assignRole(RoleEnum::SUPER_ADMIN);

        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => '',
            'username' => 'admin',
            'email' => 'admin@test.com',
            'password' => '12345678',
            'status' => true,
        ]);

        $user->assignRole(RoleEnum::ADMIN);
    }
}
