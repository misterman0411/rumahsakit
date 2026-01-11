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
        Schema::create('pharmacy_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('invoice_number')->unique();
            $table->decimal('total_amount', 12, 2);
            $table->string('status')->default('pending'); // pending, processing, shipped, completed, cancelled
            $table->string('payment_status')->default('unpaid'); // unpaid, paid, failed, expired
            $table->text('shipping_address');
            $table->string('shipping_phone');
            $table->string('snap_token')->nullable();
            $table->timestamps();
        });

        Schema::create('pharmacy_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('medication_id')->constrained('obat'); // Assuming 'obat' is table name
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pharmacy_order_items');
        Schema::dropIfExists('pharmacy_orders');
    }
};
