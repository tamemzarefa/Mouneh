<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            if (!Schema::hasColumn('product_images', 'product_id')) {
                $table->unsignedBigInteger('product_id')->index();
            }
            $table->foreign('product_id', 'product_images_product_id_foreign')
                ->references('id')->on('products')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            if (Schema::hasColumn('product_images', 'product_id')) {
                $table->dropForeign('product_images_product_id_foreign');
            }
        });
    }
};
