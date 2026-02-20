<?php

use App\Models\User;

test('authenticated users can view their profile', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;

    $response = $this->getJson('/api/me', [
        'Authorization' => "Bearer {$token}",
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
});

test('authenticated users can update their profile', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;

    $response = $this->putJson('/api/profile', [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ], [
        'Authorization' => "Bearer {$token}",
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Profile updated successfully.',
            'user' => [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
            ],
        ]);
});
