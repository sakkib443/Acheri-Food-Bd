<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('coupon_code')->nullable()->after('payment_method');
            $table->unsignedInteger('discount')->default(0)->after('subtotal');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['coupon_code', 'discount']);
        });
    }
};
