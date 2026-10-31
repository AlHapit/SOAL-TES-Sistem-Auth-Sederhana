<?php

namespace Tests\Feature;

use Database\Seeders\DemoAccountSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoAccountsLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_demo_account_can_authenticate_and_redirect_to_admin_dashboard(): void
    {
        $this->seed(DemoAccountSeeder::class);

        $response = $this->post('/login', [
            'email' => 'admin@polimind.local',
            'password' => 'Admin123!',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
        $this->assertSame('admin', auth()->user()->role);
    }

    public function test_dosen_demo_account_can_authenticate_and_redirect_to_dosen_dashboard(): void
    {
        $this->seed(DemoAccountSeeder::class);

        $response = $this->post('/login', [
            'email' => 'dosen@polimind.local',
            'password' => 'Dosen123!',
        ]);

        $response->assertRedirect('/dosen/dashboard');
        $this->assertAuthenticated();
        $this->assertSame('dosen', auth()->user()->role);
    }

    public function test_mahasiswa_demo_account_can_authenticate_and_redirect_to_mahasiswa_dashboard(): void
    {
        $this->seed(DemoAccountSeeder::class);

        $response = $this->post('/login', [
            'email' => 'mahasiswa@polimind.local',
            'password' => 'Mahasiswa123!',
        ]);

        $response->assertRedirect('/mahasiswa/dashboard');
        $this->assertAuthenticated();
        $this->assertSame('mahasiswa', auth()->user()->role);
    }
}
