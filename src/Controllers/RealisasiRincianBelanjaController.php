<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\RealisasiSubkegiatan;
use App\Models\Subkegiatan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RealisasiRincianBelanjaController extends Controller
{
    public function index(Request $request): View
    {
        $uuid = $request->query('uuid'); // Ambil parameter query 'uuid'
        $data['realisasi_subkegiatan'] = RealisasiSubkegiatan::where('uuid', $uuid)->first();
        if ($data['realisasi_subkegiatan']) {
            $data['menu'] = 'perencanaan';
            $data['submenu'] = 'realisasi';
            return view('backend.pages.realisasi.rincian-belanja.index', $data);
        } else {
            return abort(403);
        }
    }
}
