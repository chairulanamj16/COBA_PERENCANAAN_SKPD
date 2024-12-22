<?php

namespace App\Livewire\Backend\Realisasi\Kegiatan;

use App\Models\Kegiatan;
use App\Models\RealisasiKegiatan;
use Livewire\Component;

class Index extends Component
{
    public $program;

    // FORM REALISASI
    public $triwulan = [];
    public $capaian = [];

    // Model Form
    public $kode, $kegiatan, $pegawai_id;


    public function mount($program)
    {
        $this->program = $program;
    }
    public function render()
    {
        $data['kegiatans'] = Kegiatan::orderBy('kode', 'ASC')->where('program_id', $this->program->id)->get();
        return view('livewire.backend.realisasi.kegiatan.index', $data);
    }


    public function store($uuid)
    {
        $kegiatan = Kegiatan::where('uuid', $uuid)->first();
        if (empty($this->triwulan)) {
            $this->triwulan[$kegiatan->uuid] = null;
        }
        if (empty($this->capaian)) {
            $this->capaian[$kegiatan->uuid] = null;
        }

        $this->validate([
            'triwulan.' . $kegiatan->uuid => 'required|string|in:I,II,III,IV',
            'capaian.' . $kegiatan->uuid => 'required|integer'
        ]);

        $data = [
            'kegiatan_id' => $kegiatan->id,
            'uuid' => str()->uuid(),
            'triwulan' => $this->triwulan[$kegiatan->uuid],
            'capaian' => $this->capaian[$kegiatan->uuid]
        ];

        RealisasiKegiatan::create($data);

        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil menambahkan Capaian Triwulan ' . $this->triwulan[$kegiatan->uuid]);
        $this->reset(['triwulan', 'capaian']);
    }

    public function update($uuid, $field, $value)
    {
        $data = RealisasiKegiatan::where('uuid', $uuid)->first();
        if ($field == 'capaian' && !is_numeric($value)) {
            $this->dispatch('alert', title: 'Gagal!', icon: 'warning', html: 'Terdapat karakter bukan angka atau spasi berlebih saat menginput');
            return;
        }
        $data->update(
            [
                $field => $value
            ]
        );
        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil memperbaharui Realisasi ' . $data->triwulan);
    }

    public function destroy($uuid)
    {
        $data = RealisasiKegiatan::where('uuid', $uuid)->first();
        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil menghapus Triwulan ' . $data->triwulan);
        $data->delete();
    }
}
