<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile_name_and_email(): void
    {
        $user = User::create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);

        $this->actingAs($user);

        $response = $this->put(route('profile.update'), [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        $response->assertRedirect(route('profile.show'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);
    }

    public function test_user_can_update_password(): void
    {
        $user = User::create([
            'name' => 'Password User',
            'email' => 'password@example.com',
            'password' => Hash::make('old-password'),
            'role' => 'karyawan',
        ]);

        $this->actingAs($user);

        $response = $this->put(route('profile.password.update'), [
            'current_password' => 'old-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect(route('profile.show'));
        $user->refresh();
        $this->assertTrue(Hash::check('new-password', $user->password));
    }
}
