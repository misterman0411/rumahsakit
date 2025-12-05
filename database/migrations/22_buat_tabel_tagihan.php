<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tagihan')->unique();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            $table->unsignedBigInteger('tagihan_untuk_id');
            $table->string('tagihan_untuk_tipe');
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('diskon', 10, 2)->default(0);
            $table->decimal('pajak', 10, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->enum('status', ['belum_dibayar', 'dibayar_sebagian', 'lunas', 'dibatalkan'])->default('belum_dibayar');
            $table->date('jatuh_tempo')->nullable();
            $table->timestamps();
            
            $table->index(['tagihan_untuk_id', 'tagihan_untuk_tipe']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
