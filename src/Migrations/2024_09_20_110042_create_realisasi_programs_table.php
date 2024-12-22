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
        Schema::create('realisasi_programs', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('program_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('triwulan', ['I', 'II', 'III', 'IV']);
            $table->string('capaian')->nullable();
            $table->string('satuan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisasi_programs');
    }
};
