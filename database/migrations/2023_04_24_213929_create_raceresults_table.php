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
            $table->string('fastestLap');
            $table->integer('laps');
            $table->date('date');
            $table->foreignId('competitorID')->references('competitorID')->on('competitors');
            $table->foreignId('circuitID')->references('raceID')->on('races');
            $table->timestamps(false);

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
