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
        Schema::create('competitors', function (Blueprint $table) {
            $table->id('competitorID');
            $table->string('driverUrl');
            $table->string('name');
            $table->longText('description');
            $table->integer('permanentNumber');
            $table->string('nationality');
            $table->date('dateOfBirth');
            $table->float('points')->nullable();
            $table->integer('position')->nullable();
            $table->foreignId('teamID')->references('teamID')->on('teams');
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
        Schema::dropIfExists('competitors');
    }
};
