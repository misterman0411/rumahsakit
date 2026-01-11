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
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->dateTime('tanggal_kunjungan');
            $table->enum('jenis_kunjungan', ['rawat_jalan', 'rawat_inap', 'gawat_darurat'])->default('rawat_jalan');
            $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
            $table->text('keluhan_utama')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('pasien_id');
            $table->index('tanggal_kunjungan');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};
