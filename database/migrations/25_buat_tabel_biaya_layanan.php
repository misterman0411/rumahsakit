<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biaya_layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan');
            $table->string('kode', 50)->unique();
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 10, 2)->default(0);
            $table->enum('kategori', ['konsultasi', 'tindakan', 'operasi', 'penunjang', 'lainnya'])->default('lainnya');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biaya_layanan');
    }
};
