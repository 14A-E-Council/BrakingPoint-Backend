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
        Schema::create('raceresults', function (Blueprint $table) {
            $table->id('raceResultID');
            $table->string('raceName');
            $table->integer('position');
            $table->float('points');
            $table->integer('fastestLap');
            $table->string('time');
            $table->integer('laps');
            $table->foreignId('competitorID')->references('competitorID')->on('competitors');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raceresults');
    }
};
