<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertOk();
        $response->assertSee('assets/character/Unknown-Idle.png');
        $response->assertSee('Create your identity');
        $response->assertSee('Name');
        $response->assertSee('Email');
        $response->assertSee('Password');
        $response->assertSee('Role');
        $response->assertSee(route('login'));
    }

    public function test_login_screen_contains_link_to_register(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee(route('register'));
    }

    public function test_authenticated_user_cannot_view_registration_form(): void
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect();
    }

    public function test_new_user_can_register_as_mahasiswa(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Mahasiswa',
            'email' => 'unique-test@example.com',
            'password' => 'Test123!',
            'role' => 'mahasiswa',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('status', 'Registrasi berhasil. Silakan login.');

        $this->assertDatabaseHas('users', [
            'email' => 'unique-test@example.com',
            'name' => 'Test Mahasiswa',
            'role' => 'mahasiswa',
        ]);

        $user = User::where('email', 'unique-test@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('Test123!', $user->password));

        // Verify login with newly registered user
        $loginResponse = $this->post('/login', [
            'email' => 'unique-test@example.com',
            'password' => 'Test123!',
        ]);

        $loginResponse->assertRedirect('/mahasiswa/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_new_user_can_register_as_dosen(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Dosen',
            'email' => 'dosen-baru@example.com',
            'password' => 'Dosen123!',
            'role' => 'dosen',
        ]);

        $response->assertRedirect('/login');
        $user = User::where('email', 'dosen-baru@example.com')->firstOrFail();
        $this->assertSame('dosen', $user->role);

        $loginResponse = $this->post('/login', [
            'email' => 'dosen-baru@example.com',
            'password' => 'Dosen123!',
        ]);

        $loginResponse->assertRedirect('/dosen/dashboard');
    }

    public function test_new_user_can_register_as_admin(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Admin',
            'email' => 'admin-baru@example.com',
            'password' => 'Admin123!',
            'role' => 'admin',
        ]);

        $response->assertRedirect('/login');
        $user = User::where('email', 'admin-baru@example.com')->firstOrFail();
        $this->assertSame('admin', $user->role);

        $loginResponse = $this->post('/login', [
            'email' => 'admin-baru@example.com',
            'password' => 'Admin123!',
        ]);

        $loginResponse->assertRedirect('/admin/dashboard');
    }

    public function test_registration_requires_all_fields(): void
    {
        $response = $this->from('/register')->post('/register', []);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['name', 'email', 'password', 'role']);
    }

    public function test_registration_requires_valid_email(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Valid Name',
            'email' => 'not-an-email',
            'password' => 'ValidPassword123',
            'role' => 'mahasiswa',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('email');
    }

    public function test_registration_rejects_duplicate_email(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->from('/register')->post('/register', [
            'name' => 'Another User',
            'email' => 'existing@example.com',
            'password' => 'Secret123',
            'role' => 'mahasiswa',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors([
            'email' => 'Email sudah terdaftar.',
        ]);
    }

    public function test_registration_requires_password_of_at_least_6_characters(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Short Pass',
            'email' => 'shortpass@example.com',
            'password' => '12345',
            'role' => 'mahasiswa',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('password');
    }

    public function test_registration_rejects_invalid_role(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Hacker Role',
            'email' => 'hacker@example.com',
            'password' => 'Secret123',
            'role' => 'superadmin',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('role');
    }
}
