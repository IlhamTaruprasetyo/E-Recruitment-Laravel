<?php

use App\Models\User;
use Livewire\Volt\Volt;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response
        ->assertOk()
        ->assertSeeVolt('pages.auth.login');
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $component = Volt::test('pages.auth.login')
        ->set('form.email', $user->email)
        ->set('form.password', 'password');

    $component->call('login');

    $component
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $component = Volt::test('pages.auth.login')
        ->set('form.email', $user->email)
        ->set('form.password', 'wrong-password');

    $component->call('login');

    $component
        ->assertHasErrors()
        ->assertNoRedirect();

    $this->assertGuest();
});

test('navigation menu can be rendered', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get('/dashboard');

    $response
        ->assertOk()
        ->assertSeeVolt('layout.navigation');
});

test('users can logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $component = Volt::test('layout.navigation');

    $component->call('logout');

    $component
        ->assertHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
});

test('session timeout redirects to login with error message', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->withSession(['last_activity_time' => time() - 400])
        ->get('/dashboard');

    $response->assertRedirect(route('login', ['timeout' => 1]));
    $response->assertSessionHas('error');
});

test('login page with timeout parameter logs out and redirects with error', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get('/login?timeout=1');

    $response->assertRedirect(route('login', ['timeout' => 1]));
    $response->assertSessionHas('error');
});

test('guest visiting login with timeout parameter sees error message', function () {
    $response = $this->get('/login?timeout=1');

    $response->assertOk();
    $response->assertSee('Sesi Anda telah berakhir');
});
