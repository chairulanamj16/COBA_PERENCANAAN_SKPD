<?php

namespace App\Livewire\Backend\Dpa;

use App\Models\IndikatorProgram;
use App\Models\Pegawai;
use App\Models\Program;
use Livewire\Component;
use RalphJSmit\Livewire\Urls\Facades\Url;

class Index extends Component
{
    // Model Filter
    public  $tahun_anggaran, $apbd;

    // Model Form
    public $pegawai_id, $kode, $program, $target, $satuan;

    // Model Duplicate
    public $tahun_apbd = ['tahun_awal' => '', 'apbd_awal' => '', 'tahun_tujuan' => '', 'apbd_tujuan' => ''];

    public $indikator = [];

    public function mount()
    {
        $this->tahun_anggaran = date('Y');
        $this->apbd = 'murni';
    }

    public function render()
    {
        $data['pegawais'] = Pegawai::where('status', 'PNS')->get();
        $data['programs'] = Program::orderBy('kode', 'ASC')
            ->where('tahun_anggaran', $this->tahun_anggaran)->where('apbd', $this->apbd)
            ->get();
        return view('livewire.backend.dpa.index', $data);
    }


    public function storeProgram()
    {

        $this->validate([
            'pegawai_id' => 'required|string',
            'kode' => 'required|string',
            'program' => 'required|string',
            'tahun_anggaran' => 'required|string',
            'apbd' => 'required|string|in:murni,perubahan',
            'target' => 'required|integer',
            'satuan' => 'required|string',
        ]);

        $pegawai = Pegawai::where('uuid', $this->pegawai_id)->first();
        $data = [
            'uuid' => str()->uuid(),
            'pegawai_id' => $pegawai->id,
            'kode' => $this->kode,
            'title' => $this->program,
            'tahun_anggaran' => $this->tahun_anggaran,
            'apbd' => $this->apbd,
            'target' => $this->target,
            'satuan' => $this->satuan
        ];

        Program::create($data);

        // session()->flash('message', $data['uuid']);
        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil menambahkan Program');
        $this->reset(['pegawai_id', 'kode', 'program', 'target', 'satuan']);
    }

    public function storeIndikator($uuid)
    {
        dd('ok');
        // if (empty($this->indikator)) {
        //     $this->indikator[$program->uuid] = null;
        // }

        // $this->validate([
        //     'indikator.' . $program->uuid => 'required|string',
        // ]);

        // $data = [
        //     'uuid' => str()->uuid(),
        //     'program_id' => $program->id,
        //     'title' => $this->indikator[$program->uuid],
        // ];


        // IndikatorProgram::create($data);

        // $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil menambahkan Indikator Program');
        // $this->reset(['indikator']);
    }

    public function updateProgram($uuid, $field, $value)
    {
        $pegawai = ($field == 'pegawai_id') ? Pegawai::where('uuid', $value)->first() : null;
        $data = Program::where('uuid', $uuid)->first();
        if ($field == 'target' && !is_numeric($value)) {
            $this->dispatch('alert', title: 'Gagal!', icon: 'warning', html: 'Terdapat karakter bukan angka atau spasi berlebih saat menginput ');
            return;
        }
        $data->update(
            [
                $field => (is_null($pegawai)) ? $value : $pegawai->id
            ]
        );
        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil memperbaharui Program');
    }

    public function updateIndikator($uuid, $field, $value)
    {
        // $data = IndikatorProgram::where('uuid', $uuid)->first();
        // $data->update([
        //     $field => $value
        // ]);
        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil memperbaharui Indikator Program');
    }

    public function destroyProgram($uuid)
    {
        $data = Program::where('uuid', $uuid)->first();
        $data->delete();
        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil menghapus Program');
    }

    public function destroyIndikator($uuid)
    {
        // $data = IndikatorProgram::where('uuid', $uuid)->first();
        // $data->delete();
        // $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil menghapus Indikator Program');
    }
}
