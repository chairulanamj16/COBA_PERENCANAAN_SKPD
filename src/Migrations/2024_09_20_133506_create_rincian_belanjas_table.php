<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rincian_belanjas', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('realisasi_subkegiatan_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('rincian');
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->text('file')->nullable();
            $table->double('pagu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_belanjas');
    }
};
