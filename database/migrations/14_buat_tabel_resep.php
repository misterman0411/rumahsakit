<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resep', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_resep')->unique();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            $table->foreignId('dokter_id')->constrained('dokter')->cascadeOnDelete();
            $table->enum('status', ['menunggu', 'diverifikasi', 'diserahkan', 'ditolak', 'dibatalkan'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamp('waktu_verifikasi')->nullable();
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('waktu_penyerahan')->nullable();
            $table->foreignId('diserahkan_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->text('alasan_penolakan')->nullable();
            $table->foreignId('ditolak_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('waktu_penolakan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resep');
    }
};
