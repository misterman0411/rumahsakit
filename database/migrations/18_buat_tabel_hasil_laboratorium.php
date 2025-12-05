<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_laboratorium', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permintaan_id')->constrained('permintaan_laboratorium')->cascadeOnDelete();
            $table->text('hasil');
            $table->string('nilai')->nullable();
            $table->string('satuan')->nullable();
            $table->string('nilai_rujukan')->nullable();
            $table->enum('status', ['normal', 'tinggi', 'rendah', 'kritis'])->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('diperiksa_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('waktu_pemeriksaan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_laboratorium');
    }
};
