<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add kunjungan_id to janji_temu (appointments)
        Schema::table('janji_temu', function (Blueprint $table) {
            $table->foreignId('kunjungan_id')->nullable()->after('id')->constrained('kunjungan')->onDelete('set null');
            $table->index('kunjungan_id');
        });

        // Add kunjungan_id to resep (prescriptions)
        Schema::table('resep', function (Blueprint $table) {
            $table->foreignId('kunjungan_id')->nullable()->after('id')->constrained('kunjungan')->onDelete('set null');
            $table->index('kunjungan_id');
        });

        // Add kunjungan_id to pesanan_laboratorium (laboratory orders)
        Schema::table('permintaan_laboratorium', function (Blueprint $table) {
            $table->foreignId('kunjungan_id')->nullable()->after('id')->constrained('kunjungan')->onDelete('set null');
            $table->index('kunjungan_id');
        });

        // Add kunjungan_id to pesanan_radiologi (radiology orders)
        Schema::table('permintaan_radiologi', function (Blueprint $table) {
            $table->foreignId('kunjungan_id')->nullable()->after('id')->constrained('kunjungan')->onDelete('set null');
            $table->index('kunjungan_id');
        });

        // Add kunjungan_id to tagihan (invoices)
        Schema::table('tagihan', function (Blueprint $table) {
            $table->foreignId('kunjungan_id')->nullable()->after('pasien_id')->constrained('kunjungan')->onDelete('set null');
            $table->index('kunjungan_id');
        });

        // Add kunjungan_id to penerimaan_rawat_inap (inpatient admissions)
        Schema::table('rawat_inap', function (Blueprint $table) {
            $table->foreignId('kunjungan_id')->nullable()->after('id')->constrained('kunjungan')->onDelete('set null');
            $table->index('kunjungan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('janji_temu', function (Blueprint $table) {
            $table->dropForeign(['kunjungan_id']);
            $table->dropColumn('kunjungan_id');
        });

        Schema::table('resep', function (Blueprint $table) {
            $table->dropForeign(['kunjungan_id']);
            $table->dropColumn('kunjungan_id');
        });

        Schema::table('permintaan_laboratorium', function (Blueprint $table) {
            $table->dropForeign(['kunjungan_id']);
            $table->dropColumn('kunjungan_id');
        });

        Schema::table('permintaan_radiologi', function (Blueprint $table) {
            $table->dropForeign(['kunjungan_id']);
            $table->dropColumn('kunjungan_id');
        });

        Schema::table('tagihan', function (Blueprint $table) {
            $table->dropForeign(['kunjungan_id']);
            $table->dropColumn('kunjungan_id');
        });

        Schema::table('rawat_inap', function (Blueprint $table) {
            $table->dropForeign(['kunjungan_id']);
            $table->dropColumn('kunjungan_id');
        });
    }
};
