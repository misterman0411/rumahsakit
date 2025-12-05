<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rawat_inap', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_rawat_inap')->unique();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            $table->foreignId('dokter_id')->constrained('dokter')->cascadeOnDelete();
            $table->foreignId('ruangan_id')->constrained('ruangan')->cascadeOnDelete();
            $table->foreignId('tempat_tidur_id')->constrained('tempat_tidur')->cascadeOnDelete();
            $table->timestamp('tanggal_masuk');
            $table->timestamp('tanggal_keluar')->nullable();
            $table->enum('jenis_masuk', ['darurat', 'terjadwal'])->default('terjadwal');
            $table->text('alasan_masuk');
            $table->enum('status', ['dirawat', 'pulang'])->default('dirawat');
            $table->text('resume_keluar')->nullable();
            $table->text('instruksi_pulang')->nullable();
            $table->date('tanggal_kontrol')->nullable();
            $table->enum('status_pulang', ['sembuh', 'dirujuk', 'meninggal', 'pulang_paksa'])->nullable();
            $table->decimal('diskon', 10, 2)->default(0);
            $table->decimal('pajak', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rawat_inap');
    }
};
