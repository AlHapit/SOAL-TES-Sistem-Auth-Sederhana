<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'mahasiswa' => User::where('role', 'mahasiswa')->orderBy('name')->get(),
            'dosen' => User::where('role', 'dosen')->orderBy('name')->get(),
        ]);
    }
}
