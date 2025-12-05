<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('janji_temu', function (Blueprint $table) {
            $table->integer('nomor_antrian')->nullable()->after('waktu_check_in');
            $table->timestamp('waktu_mulai_konsultasi')->nullable()->after('nomor_antrian');
            $table->string('kode_antrian', 50)->nullable()->after('waktu_mulai_konsultasi');
        });
    }

    public function down(): void
    {
        Schema::table('janji_temu', function (Blueprint $table) {
            $table->dropColumn(['nomor_antrian', 'waktu_mulai_konsultasi', 'kode_antrian']);
        });
    }
};
