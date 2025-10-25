<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('legal_name')->nullable()->after('name');
            $table->string('entity_type')->nullable()->after('legal_name'); // company|establishment|sole
            $table->string('registration_number')->nullable()->after('entity_type');
            $table->string('tax_number')->nullable()->after('registration_number');
            $table->string('country')->nullable()->after('tax_number');
            $table->string('city')->nullable()->after('country');
            $table->date('established_at')->nullable()->after('city');
            $table->string('support_email')->nullable()->after('website');
            $table->string('support_phone')->nullable()->after('support_email');
            $table->string('address')->nullable()->after('support_phone');
            $table->text('shipping_policy')->nullable()->after('address');
            $table->text('return_policy')->nullable()->after('shipping_policy');
            $table->text('warranty_policy')->nullable()->after('return_policy');
            $table->enum('review_status', ['pending','needs_more_info','approved','rejected'])->default('pending')->after('status');
            $table->text('review_note')->nullable()->after('review_status');
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn([
                'legal_name','entity_type','registration_number','tax_number','country','city','established_at',
                'support_email','support_phone','address','shipping_policy','return_policy','warranty_policy',
                'review_status','review_note'
            ]);
        });
    }
};
