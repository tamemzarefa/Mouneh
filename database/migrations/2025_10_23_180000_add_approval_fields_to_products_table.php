<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('is_active');
            $table->foreignId('approved_by')->nullable()->after('status')->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('rejection_reason')->nullable()->after('approved_at');
            $table->index(['status']);
        });

        // Backfill: mark existing active products as approved
        DB::table('products')->where('is_active', true)->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropConstrainedForeignId('approved_by');
            $table->dropColumn(['status','approved_at','rejection_reason']);
        });
    }
};
