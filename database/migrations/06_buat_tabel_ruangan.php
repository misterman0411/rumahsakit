<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nomor_ruangan', 20)->unique();
            $table->foreignId('departemen_id')->constrained('departemen')->cascadeOnDelete();
            $table->enum('jenis', ['vip', 'kelas_1', 'kelas_2', 'kelas_3', 'icu', 'isolasi'])->default('kelas_3');
            $table->decimal('tarif_per_hari', 10, 2)->default(0);
            $table->integer('kapasitas')->default(1);
            $table->enum('status', ['tersedia', 'terisi', 'maintenance'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};
