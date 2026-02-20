<?php

test('the application redirects unauthenticated users to register', function () {
    $response = $this->get('/');

    $response->assertRedirect('/register');
});

test('authenticated users are redirected to dashboard', function () {
    $user = \App\Models\User::factory()->create();

    $response = $this->actingAs($user)->get('/');

    $response->assertRedirect('/userdashboard');
});
