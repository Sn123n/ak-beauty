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
        Schema::create('french_manicures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title2');
            $table->string('image');
            $table->string('image2');
            $table->text('content');
            $table->text('content2');
            $table->string('status')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('french_manicures');
    }
};
