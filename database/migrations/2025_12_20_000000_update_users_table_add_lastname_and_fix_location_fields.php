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
        Schema::table('users', function (Blueprint $table) {
            // Add lastname field after name
            if (!Schema::hasColumn('users', 'lastname')) {
                $table->string('lastname')->nullable()->after('name');
            }
        });
        
        // Change country, state, city from varchar to integer for location_id
        // Note: This requires doctrine/dbal package. If not installed, run: composer require doctrine/dbal
        // If you have existing non-numeric data, you may need to clean it first
        if (Schema::hasColumn('users', 'country')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('country')->nullable()->change();
            });
        }
        
        if (Schema::hasColumn('users', 'state')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('state')->nullable()->change();
            });
        }
        
        if (Schema::hasColumn('users', 'city')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('city')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop lastname if exists
            if (Schema::hasColumn('users', 'lastname')) {
                $table->dropColumn('lastname');
            }
            
            // Revert country, state, city back to varchar
            $table->string('country')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('city')->nullable()->change();
        });
    }
};

