<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaan_laboratorium', function (Blueprint $table) {
            // Audit trail for sample collection
            $table->foreignId('sampel_diambil_oleh')->nullable()->after('sample_collected_at')->constrained('users')->nullOnDelete();
            
            // Audit trail for result entry
            $table->foreignId('hasil_diinput_oleh')->nullable()->after('sampel_diambil_oleh')->constrained('users')->nullOnDelete();
            $table->timestamp('waktu_input_hasil')->nullable()->after('hasil_diinput_oleh');
            
            // Audit trail for verification
            $table->foreignId('diverifikasi_oleh')->nullable()->after('waktu_input_hasil')->constrained('users')->nullOnDelete();
            $table->timestamp('waktu_verifikasi')->nullable()->after('diverifikasi_oleh');
        });
    }

    public function down(): void
    {
        Schema::table('permintaan_laboratorium', function (Blueprint $table) {
            $table->dropForeign(['sampel_diambil_oleh']);
            $table->dropForeign(['hasil_diinput_oleh']);
            $table->dropForeign(['diverifikasi_oleh']);
            $table->dropColumn([
                'sampel_diambil_oleh',
                'hasil_diinput_oleh',
                'waktu_input_hasil',
                'diverifikasi_oleh',
                'waktu_verifikasi'
            ]);
        });
    }
};
