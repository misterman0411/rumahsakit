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
        Schema::table('pharmacy_orders', function (Blueprint $table) {
            $table->string('payment_method')->default('cash'); // qris, debit, credit, cash
            $table->string('delivery_method')->default('delivery'); // pickup, delivery
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pharmacy_orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'delivery_method']);
        });
    }
};
