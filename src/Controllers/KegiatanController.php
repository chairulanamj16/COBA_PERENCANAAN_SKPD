<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KegiatanController extends Controller
{
    public function index(Request $request): View
    {
        $uuid = $request->query('uuid'); // Ambil parameter query 'uuid'
        if ($uuid) {
            $data['menu'] = 'perencanaan';
            $data['submenu'] = 'dpa';
            $data['program'] = Program::where('uuid', $uuid)->first();
            return view('backend.pages.dpa.kegiatan.index', $data);
        } else {
            return abort(403);
        }
    }
}