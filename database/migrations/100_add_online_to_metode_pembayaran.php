<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Alter ENUM column to add 'online' option
        DB::statement("ALTER TABLE pembayaran MODIFY COLUMN metode_pembayaran ENUM('tunai', 'transfer', 'kartu_debit', 'kartu_kredit', 'bpjs', 'asuransi', 'online') DEFAULT 'tunai'");
    }

    public function down(): void
    {
        // Remove 'online' from ENUM
        DB::statement("ALTER TABLE pembayaran MODIFY COLUMN metode_pembayaran ENUM('tunai', 'transfer', 'kartu_debit', 'kartu_kredit', 'bpjs', 'asuransi') DEFAULT 'tunai'");
    }
};
