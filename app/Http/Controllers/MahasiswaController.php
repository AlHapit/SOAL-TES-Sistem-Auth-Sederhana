<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class MahasiswaController extends Controller
{
    public function index(): View
    {
        return view('mahasiswa.dashboard');
    }
}
