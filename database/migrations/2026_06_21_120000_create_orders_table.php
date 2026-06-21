<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('address');
            $table->string('city')->nullable();
            $table->text('note')->nullable();
            $table->string('payment_method')->default('cod');
            $table->unsignedInteger('subtotal')->default(0);
            $table->unsignedInteger('delivery_charge')->default(0);
            $table->unsignedInteger('total')->default(0);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
