<?php

namespace App\Livewire\Backend\Realisasi\Subkegiatan;

use App\Models\RealisasiSubkegiatan;
use App\Models\Subkegiatan;
use Livewire\Component;

class Index extends Component
{
    public $kegiatan;

    // FORM REALISASI
    public $triwulan = [];
    public $capaian = [];

    public function mount($kegiatan)
    {
        $this->kegiatan = $kegiatan;
    }
    public function render()
    {
        $data['subkegiatans'] = Subkegiatan::orderBy('kode', 'ASC')->where('kegiatan_id', $this->kegiatan->id)->get();
        $data['subkegiatan_realisasis'] = RealisasiSubkegiatan::all();
        return view('livewire.backend.realisasi.subkegiatan.index', $data);
    }

    public function store($uuid)
    {
        $subkegiatan = Subkegiatan::where('uuid', $uuid)->first();
        if (empty($this->triwulan)) {
            $this->triwulan[$subkegiatan->uuid] = null;
        }
        if (empty($this->capaian)) {
            $this->capaian[$subkegiatan->uuid] = null;
        }

        $this->validate([
            'triwulan.' . $subkegiatan->uuid => 'required|string|in:I,II,III,IV',
            'capaian.' . $subkegiatan->uuid => 'required|integer'
        ]);

        $data = [
            'subkegiatan_id' => $subkegiatan->id,
            'uuid' => str()->uuid(),
            'triwulan' => $this->triwulan[$subkegiatan->uuid],
            'capaian' => $this->capaian[$subkegiatan->uuid]
        ];

        RealisasiSubkegiatan::create($data);

        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil menambahkan Capaian Triwulan ' . $this->triwulan[$subkegiatan->uuid]);
        $this->reset(['triwulan', 'capaian']);
    }

    public function update($uuid, $field, $value)
    {
        $data = RealisasiSubkegiatan::where('uuid', $uuid)->first();
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
        $data = RealisasiSubkegiatan::where('uuid', $uuid)->first();
        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil menghapus Triwulan ' . $data->triwulan);
        $data->delete();
    }
}
