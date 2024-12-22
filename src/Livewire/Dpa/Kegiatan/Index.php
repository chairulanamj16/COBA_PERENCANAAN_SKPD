<?php

namespace App\Livewire\Backend\Dpa\Kegiatan;

use App\Models\IndikatorKegiatan;
use App\Models\Kegiatan;
use App\Models\Pegawai;
use Livewire\Component;

class Index extends Component
{
    public $program;

    public $pegawai_id, $kode, $kegiatan, $target, $satuan;

    public $indikator = [];

    public function mount($program)
    {
        $this->program = $program;
    }

    public function render()
    {
        $data['kegiatans'] = Kegiatan::orderBy('kode', 'ASC')
            ->where('program_id', $this->program->id)
            ->get();
        $data['pegawais'] = Pegawai::where('status', 'PNS')->get();
        return view('livewire.backend.dpa.kegiatan.index', $data);
    }


    public function storeKegiatan()
    {
        $this->validate([
            'pegawai_id' => 'required|exists:pegawais,uuid',
            'kode' => 'required|string|max:100',
            'kegiatan' => 'required|string',
            'target' => 'required|integer',
            'satuan' => 'required|string',
        ]);

        $pegawai = Pegawai::where('uuid', $this->pegawai_id)->first();

        Kegiatan::create([
            'program_id' => $this->program->id,
            'pegawai_id' => $pegawai->id,
            'uuid' => str()->uuid(),
            'kode' => $this->kode,
            'title' => $this->kegiatan,
            'target' => $this->target,
            'satuan' => $this->satuan,
        ]);
        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil menambahkan Kegiatan');
        $this->reset(['pegawai_id', 'kode', 'kegiatan', 'target', 'satuan']);
    }


    public function storeIndikator($uuid)
    {
        $kegiatan = Kegiatan::where('uuid', $uuid)->first();
        if (empty($this->indikator)) {
            $this->indikator[$kegiatan->uuid] = null;
        }

        $this->validate([
            'indikator.' . $kegiatan->uuid => 'required|string',
        ]);

        $data = [
            'uuid' => str()->uuid(),
            'kegiatan_id' => $kegiatan->id,
            'title' => $this->indikator[$kegiatan->uuid],
        ];

        IndikatorKegiatan::create($data);

        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil menambahkan Indikator Kegiatan');
        $this->reset(['indikator']);
    }

    public function updateKegiatan($uuid, $field, $value)
    {
        $pegawai = ($field == 'pegawai_id') ? Pegawai::where('uuid', $value)->first() : null;
        $data = Kegiatan::where('uuid', $uuid)->first();
        if ($field == 'target' && !is_numeric($value)) {
            $this->dispatch('alert', title: 'Gagal!', icon: 'warning', html: 'Terdapat karakter bukan angka atau spasi berlebih saat menginput ');
            return;
        }
        $data->update(
            [
                $field => (is_null($pegawai)) ? $value : $pegawai->id
            ]
        );
        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil memperbaharui Kegiatan');
    }

    public function updateIndikator($uuid, $field, $value)
    {
        $data = IndikatorKegiatan::where('uuid', $uuid)->first();
        $data->update(
            [
                $field => $value
            ]
        );
        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil memperbaharui Indikator Kegiatan');
    }

    public function destroyKegiatan($uuid)
    {
        $data = Kegiatan::where('uuid', $uuid)->first();
        $data->delete();
        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil menghapus Kegiatan');
    }

    public function destroyIndikator($uuid)
    {
        $data = IndikatorKegiatan::where('uuid', $uuid)->first();
        $data->delete();
        $this->dispatch('alert', title: 'Sukses!', icon: 'success', html: 'Berhasil menghapus Indikator Kegiatan');
    }
}
