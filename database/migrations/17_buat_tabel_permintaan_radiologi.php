<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permintaan_radiologi', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_permintaan')->unique();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            $table->foreignId('dokter_id')->constrained('dokter')->cascadeOnDelete();
            $table->foreignId('jenis_tes_id')->constrained('jenis_tes_radiologi')->cascadeOnDelete();
            $table->enum('status', ['menunggu', 'sedang_diproses', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->text('catatan_klinis')->nullable();
            $table->text('hasil')->nullable();
            $table->text('interpretasi')->nullable();
            $table->foreignId('diperiksa_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('waktu_pemeriksaan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_radiologi');
    }
};
