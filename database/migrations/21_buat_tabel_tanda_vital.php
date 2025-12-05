<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanda_vital', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            $table->foreignId('perawat_id')->nullable()->constrained('perawat')->nullOnDelete();
            $table->foreignId('rawat_inap_id')->nullable()->constrained('rawat_inap')->nullOnDelete();
            $table->decimal('suhu', 4, 1)->nullable();
            $table->integer('tekanan_darah_sistolik')->nullable();
            $table->integer('tekanan_darah_diastolik')->nullable();
            $table->integer('detak_jantung')->nullable();
            $table->integer('laju_pernapasan')->nullable();
            $table->decimal('saturasi_oksigen', 5, 2)->nullable();
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamp('waktu_pengukuran');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanda_vital');
    }
};
