<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaan_radiologi', function (Blueprint $table) {
            // Image upload support
            $table->string('image_path')->nullable()->after('hasil');
            
            // Draft/Final workflow
            $table->enum('report_status', ['draft', 'final'])->default('draft')->after('status');
            
            // Digital signature
            $table->foreignId('signed_by')->nullable()->after('report_status')->constrained('users')->nullOnDelete();
            $table->timestamp('signed_at')->nullable()->after('signed_by');
            
            // Revision tracking
            $table->integer('version')->default(1)->after('signed_at');
            $table->foreignId('parent_revision_id')->nullable()->after('version')->constrained('permintaan_radiologi')->nullOnDelete();
            
            // Audit trail enhancement
            $table->foreignId('hasil_diinput_oleh')->nullable()->after('parent_revision_id')->constrained('users')->nullOnDelete();
            $table->timestamp('waktu_input_hasil')->nullable()->after('hasil_diinput_oleh');
        });
    }

    public function down(): void
    {
        Schema::table('permintaan_radiologi', function (Blueprint $table) {
            $table->dropForeign(['signed_by']);
            $table->dropForeign(['parent_revision_id']);
            $table->dropForeign(['hasil_diinput_oleh']);
            
            $table->dropColumn([
                'image_path',
                'report_status',
                'signed_by',
                'signed_at',
                'version',
                'parent_revision_id',
                'hasil_diinput_oleh',
                'waktu_input_hasil',
            ]);
        });
    }
};
