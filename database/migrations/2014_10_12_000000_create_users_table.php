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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('image')->nullable();
            $table->string('tel')->unique();
            $table->string('birth_day')->nullable();
            $table->string('add_village')->nullable();
            $table->string('add_city')->nullable();
            $table->string('add_province')->nullable();
            $table->string('add_detail')->nullable();
            $table->string('web')->nullable();
            $table->string('job')->nullable();
            $table->string('job_type')->nullable();
            $table->string('user_type')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
