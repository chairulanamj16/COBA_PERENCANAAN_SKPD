<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class SubkegiatanController extends Controller
{

    public function index(Request $request)
    {
        $uuid = $request->query('uuid'); // Ambil parameter query 'uuid'
        if ($uuid) {
            $data['menu'] = 'perencanaan';
            $data['submenu'] = 'dpa';
            $data['kegiatan'] = Kegiatan::where('uuid', $uuid)->first();
            return view('backend.pages.dpa.subkegiatan.index', $data);
        } else {
            return abort(403);
        }
    }
}
