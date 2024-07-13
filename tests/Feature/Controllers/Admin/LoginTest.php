<?php

declare(strict_types=1);

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

beforeEach(function () {
    Role::create([
        'name' => 'admin',
    ]);
    $permission = Permission::create([
        'name' => 'admin-dashboard',
    ]);
    $permission->assignRole('admin');
    $this->adminUser = User::factory()->withRole('admin')->create([
        'first_name' => 'test',
        'username' => 'test',
        'email' => 'test@test.com',
        'password' => bcrypt('12345678'),
    ]);
    $this->user = User::factory()->create([
        'first_name' => 'user',
        'username' => 'user',
        'email' => 'user@test.com',
        'password' => bcrypt('12345678'),
    ]);
});

test('check admin login page', function () {
    $this->get('/admin/login')->assertStatus(200);
});

test('check login form', function () {
    $this->post(route('admin.login'), [
        'username' => 'test',
        'password' => '12345678',
    ])->assertStatus(302)->assertRedirect(route('admin.dashboard'));
});

test('unsuccessful login attempt', function () {
    $this->post(route('admin.login'), [
        'username' => 'user',
        'password' => '12345678',
    ])->assertStatus(302)->assertSessionHasErrors([
        'username',
    ]);

    $this->post(route('admin.login'), [
        'username' => 'user',
        'password' => '1234',
    ])->assertStatus(302)->assertSessionHasErrors([
        'password',
    ]);
});
