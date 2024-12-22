<?php

namespace App\Livewire\Backend\Realisasi\Program;

use App\Models\Pegawai;
use App\Models\Program;
use App\Models\RealisasiProgram;
use Livewire\Component;

class Index extends Component
{
    // Model Filter
    public $tahun_anggaran, $apbd;

    // FORM REALISASI
    public $triwulan = [];
    public $capaian = [];

    // Model Form
    public $kode, $program, $pegawai_id;
    public function mount()
    {
        $this->tahun_anggaran = date('Y');
        $this->apbd = 'murni';
    }
    public function render()
    {
        if (auth()->user()->rule == 'kabid') {
            $data['programs'] = Program::orderBy('kode', 'ASC')
                ->where('pegawai_id', auth()->user()->pegawai->id)
                ->where('tahun_anggaran', $this->tahun_anggaran)->where('apbd', $this->apbd)
                ->get();
            $data['pegawais'] = Pegawai::where('id', auth()->user()->pegawai->id)->get();
        } else {
            $data['programs'] = Program::orderBy('kode', 'ASC')
                ->where('tahun_anggaran', $this->tahun_anggaran)->where('apbd', $this->apbd)
                ->get();
            $data['pegawais'] = Pegawai::where('status', 'PNS')->get();
        }

        return view('livewire.backend.realisasi.program.index', $data);
    }


    public function store($uuid)
    {
        $program = Program::where('uuid', $uuid)->first();
        if (empty($this->triwulan)) {
            $this->triwulan[$program->uuid] = null;
        }
        if (empty($this->capaian)) {
            $this->capaian[$program->uuid] = null;
        }

        $this->validate([
            'triwulan.' . $program->uuid => 'required|string|in:I,II,III,IV',
            'capaian.' . $program->uuid => 'required|integer'
        ]);

        $data = [
            'program_id' => $program->id,
            'uuid' => str()->uuid(),
            'triwulan' => $this->triwulan[$program->uuid],
            'capaian' => $this->capaian[$program->uuid]
        ];

        RealisasiProgram::create($data);

        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil menambahkan Capaian Triwulan ' . $this->triwulan[$program->uuid]);
        $this->reset(['triwulan', 'capaian']);
    }

    public function update($uuid, $field, $value)
    {
        $data = RealisasiProgram::where('uuid', $uuid)->first();
        if ($field == 'capaian' && !is_numeric($value)) {
            $this->dispatch('alert', title: 'Gagal!', icon: 'warning', html: 'Terdapat karakter bukan angka atau spasi berlebih saat menginput');
            return;
        }
        $data->update(
            [
                $field => $value
            ]
        );
        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil memperbaharui Realisasi');
    }

    public function destroy($uuid)
    {
        $data = RealisasiProgram::where('uuid', $uuid)->first();
        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil menghapus Triwulan ' . $data->triwulan);
        $data->delete();
    }
}
