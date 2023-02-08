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
        Schema::create('connection_user_sport', function (Blueprint $table) {
            $table->id('connectionID');
            $table->unsignedBigInteger('sportID');
            $table->foreign('sportID')->references('sportID')->on('sports');
            $table->unsignedBigInteger('userID');
            $table->foreign('userID')->references('userID')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connection_user_sport');
    }
};
