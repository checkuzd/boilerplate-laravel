<?php

declare(strict_types=1);

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

beforeEach(function () {

    Role::create([
        'name' => 'customer',
        'title' => 'customer',
    ]);
    $this->user = User::factory()->withRole('customer')->create();

    Role::create([
        'name' => 'admin',
        'title' => 'admin',
    ]);
    $permission = Permission::create([
        'name' => 'admin-dashboard',
    ]);
    $permission->assignRole('admin');
    $this->adminUser = User::factory()->withRole('admin')->create([
        'first_name' => 'admin',
        'username' => 'admin',
        'email' => 'admin@test.com',
        'password' => bcrypt('12345678'),
        'status' => true,
    ]);
});

test('unauthenticated user cannot access admin area', function () {
    $this->get(route('admin.dashboard'))
        ->assertStatus(302)
        ->assertRedirect(route('admin.login'));
});

test('access dashboard if user has permission', function () {
    $this->actingAs($this->adminUser)->get(route('admin.dashboard'))->assertStatus(200);
});
test('redirect if user has no dashboard permission', function () {
    $this->actingAs($this->user)->get(route('admin.dashboard'))->assertStatus(403);
});
