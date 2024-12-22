<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RealisasiKegiatanController extends Controller
{
    public function index(Request $request): View
    {
        $uuid = $request->query('uuid'); // Ambil parameter query 'uuid'
        $data['program'] = Program::where('uuid', $uuid)->first();
        if ($data['program']) {
            $data['menu'] = 'perencanaan';
            $data['submenu'] = 'realisasi';
            return view('backend.pages.realisasi.kegiatan.index', $data);
        } else {
            return abort(403);
        }
    }
}
