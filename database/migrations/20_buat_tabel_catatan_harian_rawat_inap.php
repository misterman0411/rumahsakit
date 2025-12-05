<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catatan_harian_rawat_inap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rawat_inap_id')->constrained('rawat_inap')->cascadeOnDelete();
            $table->foreignId('perawat_id')->nullable()->constrained('perawat')->nullOnDelete();
            $table->foreignId('dokter_id')->nullable()->constrained('dokter')->nullOnDelete();
            $table->date('tanggal');
            $table->time('waktu');
            $table->enum('jenis', ['perkembangan', 'tindakan', 'konsultasi', 'instruksi_dokter'])->default('perkembangan');
            $table->text('catatan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catatan_harian_rawat_inap');
    }
};
