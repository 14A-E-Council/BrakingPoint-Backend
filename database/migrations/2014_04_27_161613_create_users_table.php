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
            $table->integer('balance')->default(0);
            $table->string('preferred_category')->nullable();
            $table->integer('level')->default(1);
            $table->string('picture_frame')->default("bronze.png");
            $table->integer('rank')->nullable();
            $table->string('colour_palette')->nullable();
            $table->string('profile_picture')->default("../src/assets/defaul.png");
            $table->integer('xp')->default(0);
            $table->tinyInteger('admin')->default(0);
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
