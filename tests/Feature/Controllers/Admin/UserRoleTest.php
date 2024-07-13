<?php

declare(strict_types=1);

use App\Models\Role;
use App\Models\User;

beforeEach(function () {
    Role::create([
        'name' => 'Super Admin',
    ]);
    $this->adminUser = User::factory()->withRole('Super Admin')->create();
});

test('check user validation on create', function () {
    $this->actingAs($this->adminUser)->post(route('admin.users.store'), [
        'first_name' => 'test',
        'username' => 'test',
        'email' => 'test@test.com',
        'password' => bcrypt('12345678'),
        'role' => 1,
    ])->assertStatus(302)
        ->assertRedirect(route('admin.users.edit', 2));
});

test('check user validation on create with multiple role', function () {
    $this->actingAs($this->adminUser)->post(route('admin.users.store'), [
        'first_name' => 'test',
        'username' => 'test',
        'email' => 'test@test.com',
        'password' => bcrypt('12345678'),
        'role' => ['1', '2'],
    ])->assertStatus(302)->assertSessionHasErrors([
        'role', // Expecting an error for the password field due to validation rules
    ]);
});

// test('check user validation on create with invalid role', function () {
//     $this->actingAs($this->adminUser)->post(route('admin.users.store'), [
//         'first_name' => 'test',
//         'username' => 'test',
//         'email' => 'test@test.com',
//         'password' => bcrypt('12345678'),
//         'role' => 2
//     ])->assertStatus(302)->assertSessionHasErrors([
//         'role' // Expecting an error for the password field due to validation rules
//     ]);
// });
