<?php

declare(strict_types=1);

use App\Enums\RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Response;

beforeEach(function () {
    Role::create([
        'name' => RoleEnum::SUPER_ADMIN,
    ]);
    $this->adminUser = User::factory()->withRole(RoleEnum::SUPER_ADMIN)->create();
});

test('check user validation on create', function () {
    $this->actingAs($this->adminUser)->post(route('admin.users.store'), [
        'first_name' => 'test',
        'username' => 'test',
        'email' => 'test@test.com',
        'password' => '12345678',
        'role' => 1,
    ])->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('admin.users.edit', 2));
});

test('check user validation on create with multiple role', function () {
    $this->actingAs($this->adminUser)->post(route('admin.users.store'), [
        'first_name' => 'test1',
        'username' => 'test1',
        'email' => 'test1@test.com',
        'password' => '12345678',
        'role' => ['1', '2'],
    ])->assertStatus(Response::HTTP_FOUND)->assertSessionHasErrors([
        'role', // Expecting an error for the role field due to validation rules
    ]);
});

test('check user validation on create with invalid role', function () {
    $this->actingAs($this->adminUser)->post(route('admin.users.store'), [
        'first_name' => 'test2',
        'username' => 'test2',
        'email' => 'test2@test.com',
        'password' => '12345678',
        'role' => 2,
    ])->assertStatus(Response::HTTP_FOUND)->assertSessionHasErrors([
        'role', // Expecting an error for the role field due to validation rules
    ]);
});
