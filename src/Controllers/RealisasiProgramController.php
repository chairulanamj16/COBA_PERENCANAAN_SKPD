<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RealisasiProgramController extends Controller
{
    public function index(): View
    {
        $data['menu'] = 'perencanaan';
        $data['submenu'] = 'realisasi';
        return view('backend.pages.realisasi.program.index', $data);
    }
}
