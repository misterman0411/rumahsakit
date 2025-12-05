<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('janji_temu', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_janji_temu')->unique();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            $table->foreignId('dokter_id')->constrained('dokter')->cascadeOnDelete();
            $table->foreignId('departemen_id')->constrained('departemen')->cascadeOnDelete();
            $table->dateTime('tanggal_janji');
            $table->enum('jenis', ['rawat_jalan', 'darurat', 'rawat_inap', 'kontrol_ulang'])->default('rawat_jalan');
            $table->enum('status', ['terjadwal', 'dikonfirmasi', 'check_in', 'sedang_dilayani', 'selesai', 'dibatalkan', 'tidak_hadir'])->default('terjadwal');
            $table->text('alasan');
            $table->text('catatan')->nullable();
            $table->timestamp('waktu_check_in')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('janji_temu');
    }
};
