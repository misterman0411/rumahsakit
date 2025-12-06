<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('ip_address')->index();
            $table->integer('attempts')->default(1);
            $table->timestamp('locked_until')->nullable();
            $table->timestamps();
            
            // Unique constraint untuk email dan ip_address
            $table->unique(['email', 'ip_address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_attempts');
    }
};