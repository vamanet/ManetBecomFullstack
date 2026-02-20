<?php

use App\Models\User;

test('authenticated users can logout', function () {
    $user = User::factory()->create();

    $token = $user->createToken('auth_token')->plainTextToken;

    $response = $this->postJson('/api/logout', [], [
        'Authorization' => "Bearer {$token}",
    ]);

    $response->assertStatus(200)
        ->assertJson(['message' => 'Logout successful.']);
});

test('unauthenticated users cannot logout', function () {
    $response = $this->postJson('/api/logout');

    $response->assertStatus(401);
});
