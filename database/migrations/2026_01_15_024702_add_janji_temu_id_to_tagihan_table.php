<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Note: Guard added because this file sorts before 22_buat_tabel_tagihan.php
     * alphabetically (2026 < 22), so tagihan table may not exist yet on first run.
     * The column will be added by 22_buat_tabel_tagihan.php if skipped here.
     */
    public function up(): void
    {
        if (!Schema::hasTable('tagihan')) {
            return;
        }

        if (!Schema::hasColumn('tagihan', 'janji_temu_id')) {
            Schema::table('tagihan', function (Blueprint $table) {
                $table->foreignId('janji_temu_id')->nullable()->after('kunjungan_id')->constrained('janji_temu')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('tagihan')) {
            return;
        }

        if (Schema::hasColumn('tagihan', 'janji_temu_id')) {
            Schema::table('tagihan', function (Blueprint $table) {
                $table->dropForeign(['janji_temu_id']);
                $table->dropColumn('janji_temu_id');
            });
        }
    }
};

