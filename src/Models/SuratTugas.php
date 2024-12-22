<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }

    public function pegawaiSuratTugas()
    {
        return $this->belongsToMany(Pegawai::class,);
    }
    public function pegawaiSuratTugass()
    {
        return $this->hasMany(PegawaiSuratTugas::class,);
    }

    public function laporanHasil()
    {
        return $this->hasOne(LaporanHasil::class,);
    }

    public function kuitansi()
    {
        return $this->hasOne(Kuitansi::class,);
    }

    public function kuitansi_rincian()
    {
        return $this->hasMany(KuitansiRincian::class,);
    }
}
