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
            $table->string('otp')->nullable()->after('email');
            $table->string('phone')->nullable()->after('password');
            $table->text('address')->nullable()->after('phone');
            $table->string('image')->nullable()->after('address');
            $table->string('gender')->nullable()->after('image');
            $table->string('dob')->nullable()->after('gender');
            $table->string('country')->nullable()->after('dob');
            $table->string('state')->nullable()->after('country');
            $table->string('city')->nullable()->after('state');
            $table->string('pincode')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['otp','phone', 'address', 'image','gender','dob','country','state','city','pincode']);
        });
    }
};
