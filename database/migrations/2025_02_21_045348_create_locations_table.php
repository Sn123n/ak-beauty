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
        Schema::create('location', function (Blueprint $table) {       
            $table->id('location_id');
            $table->string('name');
            $table->tinyInteger('location_type')->comment('0:country,1:state,2:city');
            $table->integer('parent_id')->comment('parent location_id');
            $table->tinyInteger('is_visible')->comment('0:visible,1:invisible');
            $table->tinyInteger('status')->comment('1:active,0:deactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location');
    }
};
