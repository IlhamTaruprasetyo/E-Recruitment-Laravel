<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;

test('profile page is displayed for admin', function () {
    $user = User::factory()->create(['role_id' => 1]);

    $this->actingAs($user);

    $response = $this->get('/profile');

    $response
        ->assertOk()
        ->assertSeeVolt('profile.update-profile-information-form')
        ->assertSeeVolt('profile.update-password-form');
});

test('profile page is displayed for applicant', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get('/profile');

    $response
        ->assertOk()
        ->assertSeeVolt('applicant.pribadi');
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $component = Volt::test('profile.update-profile-information-form')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->call('updateProfileInformation');

    $component
        ->assertHasNoErrors()
        ->assertNoRedirect();

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $component = Volt::test('profile.update-profile-information-form')
        ->set('name', 'Test User')
        ->set('email', $user->email)
        ->call('updateProfileInformation');

    $component
        ->assertHasNoErrors()
        ->assertNoRedirect();

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $component = Volt::test('profile.delete-user-form')
        ->set('password', 'password')
        ->call('deleteUser');

    $component
        ->assertHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $component = Volt::test('profile.delete-user-form')
        ->set('password', 'wrong-password')
        ->call('deleteUser');

    $component
        ->assertHasErrors('password')
        ->assertNoRedirect();

    $this->assertNotNull($user->fresh());
});

test('user can upload profile avatar', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $this->actingAs($user);

    $file = UploadedFile::fake()->image('avatar.jpg');

    $component = Volt::test('profile.update-profile-information-form')
        ->set('name', 'Admin Test')
        ->set('email', $user->email)
        ->set('photo', $file)
        ->call('updateProfileInformation');

    $component->assertHasNoErrors();

    $user->refresh();
    $this->assertNotNull($user->avatar);
    Storage::disk('public')->assertExists($user->avatar);
});

test('user can remove profile avatar', function () {
    Storage::fake('public');

    $user = User::factory()->create([
        'avatar' => 'avatars/fake-avatar.jpg',
    ]);
    Storage::disk('public')->put('avatars/fake-avatar.jpg', 'fake content');

    $this->actingAs($user);

    $component = Volt::test('profile.update-profile-information-form')
        ->call('removePhoto');

    $component->assertHasNoErrors();

    $user->refresh();
    $this->assertNull($user->avatar);
    Storage::disk('public')->assertMissing('avatars/fake-avatar.jpg');
});
