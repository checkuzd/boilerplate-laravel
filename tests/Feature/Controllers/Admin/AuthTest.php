<?php

declare(strict_types=1);

use App\Enums\RoleEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

beforeEach(function () {

    Role::create([
        'name' => RoleEnum::CUSTOMER,
    ]);
    $this->customer = User::factory()->withRole(RoleEnum::CUSTOMER)->create();

    Role::create([
        'name' => RoleEnum::ADMIN,
    ]);
    $permission = Permission::create([
        'name' => 'admin-dashboard',
    ]);
    $permission->assignRole(RoleEnum::ADMIN);
    $this->adminUser = User::factory()->withRole(RoleEnum::ADMIN)->create([
        'first_name' => 'admin',
        'username' => 'admin',
        'email' => 'admin@test.com',
        'password' => bcrypt('12345678'),
        'status' => true,
    ]);
});

test('unauthenticated user cannot access admin area', function () {
    $this->get(route('admin.dashboard'))
        ->assertStatus(302);
});

test('access dashboard if user has permission', function () {
    $this->actingAs($this->adminUser)->get(route('admin.dashboard'))->assertStatus(200);
});
test('redirect if user has no dashboard permission', function () {
    $this->actingAs($this->customer)->get(route('admin.dashboard'))->assertStatus(403);
});
