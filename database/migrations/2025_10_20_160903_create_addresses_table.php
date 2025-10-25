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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('label', 60)->nullable();
            $table->string('recipient_name', 120)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('line1', 190);
            $table->string('line2', 190)->nullable();
            $table->string('city', 120)->nullable();
            $table->string('region', 120)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->char('country_code', 2)->default('SY');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
