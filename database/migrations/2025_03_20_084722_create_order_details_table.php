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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->string('product_title');
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_subtotal', 10, 2);
            $table->string('status')->default('pending');       
            $table->string('shipped_date')->nullable();
            $table->string('estimated_delivery_date')->nullable();
            $table->string('delivered_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
