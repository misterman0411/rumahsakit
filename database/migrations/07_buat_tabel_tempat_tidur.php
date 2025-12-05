<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tempat_tidur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruangan_id')->constrained('ruangan')->cascadeOnDelete();
            $table->string('nomor_tempat_tidur', 20);
            $table->enum('status', ['tersedia', 'terisi', 'maintenance'])->default('tersedia');
            $table->timestamps();
            
            $table->unique(['ruangan_id', 'nomor_tempat_tidur']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tempat_tidur');
    }
};
