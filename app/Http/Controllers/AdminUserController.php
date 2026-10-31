<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function store(Request $request, string $role): RedirectResponse
    {
        $data = $this->validateUser($request, $role);
        $data['password'] = Hash::make($data['password']);
        User::create($data + ['role' => $role]);

        return back()->with('status', ucfirst($role).' berhasil ditambahkan.');
    }

    public function update(Request $request, string $role, User $user): RedirectResponse
    {
        abort_unless($user->role === $role, 404);
        $data = $this->validateUser($request, $role, $user);
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data + ['role' => $role]);

        return back()->with('status', ucfirst($role).' berhasil diperbarui.');
    }

    public function destroy(string $role, User $user): RedirectResponse
    {
        abort_unless($user->role === $role, 404);
        $user->delete();

        return back()->with('status', ucfirst($role).' berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function validateUser(Request $request, string $role, ?User $user = null): array
    {
        abort_unless(in_array($role, ['mahasiswa', 'dosen'], true), 404);

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:6'],
        ]);
    }
}
