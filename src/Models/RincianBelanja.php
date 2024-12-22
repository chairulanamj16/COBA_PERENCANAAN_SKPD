<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RincianBelanja extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function realisasi_subkegiatan()
    {
        return $this->belongsTo(RealisasiSubkegiatan::class);
    }
}
