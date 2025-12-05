<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('no_rekam_medis')->unique();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['laki_laki', 'perempuan']);
            $table->string('telepon', 20);
            $table->string('email')->nullable();
            $table->text('alamat');
            $table->string('golongan_darah', 5)->nullable();
            $table->text('alergi')->nullable();
            $table->string('nama_kontak_darurat')->nullable();
            $table->string('telepon_kontak_darurat', 20)->nullable();
            $table->enum('jenis_asuransi', ['tidak_ada', 'bpjs', 'asuransi_swasta'])->default('tidak_ada');
            $table->string('nomor_asuransi', 100)->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif', 'meninggal'])->default('aktif');
            $table->string('nik', 16)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->enum('agama', ['islam', 'kristen', 'katolik', 'hindu', 'buddha', 'konghucu', 'other'])->nullable();
            $table->enum('status_pernikahan', ['belum_menikah', 'menikah', 'cerai', 'janda_duda'])->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('kewarganegaraan')->default('Indonesia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
