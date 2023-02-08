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
            $table->string('last_name');
            $table->string('first_name');
            $table->string('email');
            $table->string('password');
            $table->integer('balance');
            $table->timestamp('registration_date');
            $table->string('preferred_category');
            $table->integer('level');
            $table->string('picture_frame');
            $table->integer('rank');
            $table->string('colour_palette');
            $table->string('profile_picture');
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
