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
        Schema::create('subkegiatans', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('kegiatan_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('pegawai_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('kode');
            $table->string('title');
            $table->string('target');
            $table->string('satuan');
            $table->double('pagu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subkegiatans');
    }
};
