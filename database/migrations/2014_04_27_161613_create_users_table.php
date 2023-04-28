<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('userID');
            $table->string('username');
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('email');
            $table->string('password');
            $table->integer('balance')->nullable();
            $table->string('preferred_category')->nullable();
            $table->integer('level')->nullable();
            $table->string('picture_frame')->nullable();
            $table->integer('rank')->nullable();
            $table->string('colour_palette')->nullable();
            $table->string('profile_picture')->nullable();
            $table->integer('xp')->nullable();
            $table->tinyInteger('admin')->nullable();
            $table->date('email_verified_at')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
