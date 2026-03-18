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
        Schema::create('nail_extensions', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('content')->nullable();
            $table->text('image')->nullable();
            $table->text('image2')->nullable();
            $table->text('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nail_extensions');
    }
};
