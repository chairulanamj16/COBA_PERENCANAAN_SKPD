<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RealisasiSubkegiatanController extends Controller
{
    public function index(Request $request): View
    {
        $uuid = $request->query('uuid'); // Ambil parameter query 'uuid'
        $data['kegiatan'] = Kegiatan::where('uuid', $uuid)->first();
        if ($data['kegiatan']) {
            $data['menu'] = 'perencanaan';
            $data['submenu'] = 'realisasi';
            return view('backend.pages.realisasi.subkegiatan.index', $data);
        } else {
            return abort(403);
        }
    }
}
