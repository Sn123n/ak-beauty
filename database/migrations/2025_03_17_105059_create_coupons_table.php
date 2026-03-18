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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            // $table->integer('product_id')->nullable();
            $table->string('title')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('description')->nullable();
            $table->string('discount_type')->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->decimal('discount_rupees', 10, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->tinyInteger('status')->comment('1:active,0:deactive');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
