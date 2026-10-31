<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_register_with_a_hashed_password(): void
    {
        $response = $this->post('/register', [
            'name' => 'Admin User',
            'email' => 'admin@example.test',
            'password' => 'secret1',
            'role' => 'admin',
        ]);

        $response->assertRedirect('/login')->assertSessionHas('status');
        $user = User::where('email', 'admin@example.test')->firstOrFail();

        $this->assertSame('admin', $user->role);
        $this->assertTrue(Hash::check('secret1', $user->password));
    }

    public function test_registration_rejects_duplicate_and_invalid_input(): void
    {
        User::factory()->create(['email' => 'used@example.test']);

        $this->from('/register')->post('/register', [
            'name' => '',
            'email' => 'used@example.test',
            'password' => '123',
            'role' => 'other',
        ])->assertRedirect('/register')
            ->assertSessionHasErrors(['name', 'email', 'password', 'role']);

        $this->from('/register')->post('/register', [
            'name' => 'Test User',
            'email' => 'not-an-email',
            'password' => 'secret1',
            'role' => 'mahasiswa',
        ])->assertRedirect('/register')->assertSessionHasErrors('email');
    }

    public function test_each_role_is_redirected_to_its_dashboard_after_login(): void
    {
        foreach (['admin', 'dosen', 'mahasiswa'] as $role) {
            $user = User::factory()->create([
                'email' => "{$role}@example.test",
                'password' => Hash::make('secret1'),
                'role' => $role,
            ]);

            $this->post('/login', [
                'email' => $user->email,
                'password' => 'secret1',
            ])->assertRedirect("/{$role}/dashboard");

            $this->post('/logout')->assertRedirect('/login');
        }
    }

    public function test_invalid_login_uses_the_required_generic_message(): void
    {
        User::factory()->create(['email' => 'user@example.test', 'password' => Hash::make('secret1')]);

        $this->from('/login')->post('/login', [
            'email' => 'user@example.test',
            'password' => 'incorrect',
        ])->assertRedirect('/login')
            ->assertSessionHasErrors(['email' => 'Email atau password salah']);
    }

    public function test_guests_are_redirected_to_login_for_every_dashboard(): void
    {
        foreach (['/admin/dashboard', '/dosen/dashboard', '/mahasiswa/dashboard'] as $dashboard) {
            $this->get($dashboard)->assertRedirect('/login');
        }
    }

    public function test_users_with_the_wrong_role_receive_forbidden(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $dosen = User::factory()->create(['role' => 'dosen']);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        $this->actingAs($mahasiswa)->get('/admin/dashboard')->assertForbidden();
        $this->actingAs($dosen)->get('/admin/dashboard')->assertForbidden();
        $this->actingAs($admin)->get('/mahasiswa/dashboard')->assertForbidden();
    }

    public function test_logout_invalidates_the_authenticated_session(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)->post('/logout')->assertRedirect('/login');

        $this->assertGuest();
        $this->get('/admin/dashboard')->assertRedirect('/login');
    }

    public function test_each_role_can_render_its_own_dashboard(): void
    {
        foreach (['admin', 'dosen', 'mahasiswa'] as $role) {
            $user = User::factory()->create(['role' => $role]);

            $this->actingAs($user)->get("/{$role}/dashboard")
                ->assertOk()
                ->assertSee('Politeknik Mitra Industri');
        }
    }
}
