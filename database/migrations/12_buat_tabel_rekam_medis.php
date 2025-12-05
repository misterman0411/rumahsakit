<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            $table->foreignId('dokter_id')->constrained('dokter')->cascadeOnDelete();
            $table->foreignId('janji_temu_id')->nullable()->constrained('janji_temu')->nullOnDelete();
            $table->text('keluhan');
            $table->json('tanda_vital')->nullable();
            $table->text('diagnosis');
            $table->string('kode_icd10')->nullable();
            $table->string('kode_icd9')->nullable();
            $table->text('rencana_perawatan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
