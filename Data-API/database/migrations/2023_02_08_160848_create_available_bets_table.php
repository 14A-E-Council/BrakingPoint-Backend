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
        Schema::create('available_bets', function (Blueprint $table) {
            $table->id('available_betID');
            $table->date('date');
            $table->string('category');
            $table->double('odds');
            $table->string('status');
            $table->unsignedBigInteger('sportID');
            $table->foreign('sportID')->references('sportID')->on('sports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('available_bets');
    }
};
