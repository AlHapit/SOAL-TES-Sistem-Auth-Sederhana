<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoAccountSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'Admin Polimind', 'email' => 'admin@polimind.local', 'password' => 'Admin123!', 'role' => 'admin'],
            ['name' => 'Dosen Polimind', 'email' => 'dosen@polimind.local', 'password' => 'Dosen123!', 'role' => 'dosen'],
            ['name' => 'Mahasiswa Polimind', 'email' => 'mahasiswa@polimind.local', 'password' => 'Mahasiswa123!', 'role' => 'mahasiswa'],
        ] as $account) {
            User::updateOrCreate(['email' => $account['email']], [
                'name' => $account['name'], 'password' => Hash::make($account['password']), 'role' => $account['role'],
            ]);
        }
    }
}