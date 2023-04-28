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
            $table->id();
            $table->string('username');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('email');
            $table->string('password');
            $table->integer('balance');
            $table->string('preferred_category');
            $table->integer('level');
            $table->string('picture_frame');
            $table->integer('rank');
            $table->string('colour_palette');
            $table->string('profile_picture');
            $table->integer('xp');
            $table->tinyInteger('admin');
            $table->date('email_verified_at');
            $table->string('remember_token');
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
