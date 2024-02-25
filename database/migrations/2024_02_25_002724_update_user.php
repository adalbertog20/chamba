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
            $table->foreignId('address_id')->nullable()->references('id')->on('addresses');
            $table->string('username')->unique();
            $table->float('rating')->default(0.0);
            $table->string('phone_number')->unique();
            $table->tinyInteger('role')->default(0);
            $table->string('speciality')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_id');
        Schema::dropIfExists('username');
        Schema::dropIfExists('username');
        Schema::dropIfExists('phone_number');
        Schema::dropIfExists('role');
        Schema::dropIfExists('scpeciality');
    }
};
