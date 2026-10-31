<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class DosenController extends Controller
{
    public function index(): View
    {
        return view('dosen.dashboard');
    }
}
