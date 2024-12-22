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
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('program_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('pegawai_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('kode');
            $table->string('title');
            $table->string('target');
            $table->string('satuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};