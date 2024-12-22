<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(): View
    {
        $data['menu'] = 'perencanaan';
        $data['submenu'] = 'dpa';
        return view('backend.pages.dpa.program.index', $data);
    }
}
