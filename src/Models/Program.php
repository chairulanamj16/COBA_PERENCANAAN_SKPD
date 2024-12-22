<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function indikator_program()
    {
        return $this->hasMany(IndikatorProgram::class);
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class);
    }

    public function realisasi_program()
    {
        return $this->hasMany(RealisasiProgram::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function triwulan($value)
    {
        return $this->realisasi_program()->where('triwulan', $value)->get()->first();
    }

    public function sumTotalSubKeg()
    {
        return $this->kegiatan->flatMap(function ($kegiatan) {
            return $kegiatan->subkegiatan->pluck('pagu');
        })->sum();
    }

    public function countTotalCapaian($value)
    {
        return $this->realisasi_program->where('triwulan', $value)->sum('capaian');
    }

    public function sumTotalRincian($value)
    {
        return $this->kegiatan->flatMap(function ($kegiatan) use ($value) {
            return $kegiatan->subkegiatan->flatMap(function ($subkegiatan) use ($value) {
                return $subkegiatan->realisasi_subkegiatan->where('triwulan', $value)->flatMap(function ($realisasi_program) {
                    return $realisasi_program->rincian_belanja->pluck('pagu');
                });
            });
        })->sum();
    }

    public function sumTotal()
    {
        return ($this->sumTotalRincian("I") +
            $this->sumTotalRincian("II") + $this->sumTotalRincian("III") +
            $this->sumTotalRincian("IV"));
    }
}
