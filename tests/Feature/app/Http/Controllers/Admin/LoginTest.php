<?php

declare(strict_types=1);

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('check admin login page', function () {
    $this->get('/admin/login')->assertStatus(200);
});

test('redirect to dashboard if user is authenticated', function () {
    $this->actingAs($this->user)
        ->get('/admin/login')
        ->assertStatus(302);
});
