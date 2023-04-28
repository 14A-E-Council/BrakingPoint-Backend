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

        Schema::create('teams', function (Blueprint $table) {
            $table->id('teamID');
            $table->string('name');
            $table->longText('description');
            $table->string('teamUrl');
            $table->string('nationality');
            $table->float('points')->nullable();
            $table->integer('position')->nullable();
            // $table->foreignId('sportID')->references('sportID')->on('sports');
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
        Schema::dropIfExists('teams');
    }
};
