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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories');
            $table->string('title_ar', 190);
            $table->string('title_en', 190)->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->integer('price_cents');
            $table->char('currency', 3)->default('SYP');
            $table->integer('stock')->default(0);
            $table->boolean('is_active')->default(true);
            $table->decimal('avg_rating', 3, 2)->default(0);
            $table->timestamps();
            $table->index(['seller_id']);
            $table->index(['category_id']);
            $table->index(['is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
