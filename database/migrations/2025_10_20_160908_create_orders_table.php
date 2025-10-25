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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('address_id')->constrained('addresses');
            $table->enum('status', ['pending','confirmed','shipped','delivered','cancelled'])->default('pending');
            $table->integer('subtotal_cents');
            $table->integer('shipping_cents')->default(0);
            $table->integer('discount_cents')->default(0);
            $table->integer('total_cents');
            $table->char('currency', 3)->default('SYP');
            $table->timestamps();
            $table->index('buyer_id');
            $table->index('seller_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
