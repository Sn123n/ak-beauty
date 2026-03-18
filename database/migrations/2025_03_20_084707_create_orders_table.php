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
            $table->string('order_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('sub_total', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('shipping_charge', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->string('coupon_id');
            $table->decimal('coupon_code_discount')->nullable();
            $table->decimal('coupon_title')->nullable();
            $table->string('coupon_start_date')->nullable();
            $table->string('coupon_expiry_date')->nullable();
            $table->decimal('product_discount')->nullable();
            $table->decimal('total_discount')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('status')->default('pending');
            $table->string('name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('country');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();
            $table->softDeletes();
            $table->timestamps();
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
