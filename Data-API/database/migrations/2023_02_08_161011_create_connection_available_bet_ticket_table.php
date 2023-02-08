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
        Schema::create('connection_available_bet_ticket', function (Blueprint $table) {
            $table->id('connectionID');
            $table->unsignedBigInteger('available_betID');
            $table->unsignedBigInteger('ticketID');
            $table->foreign('available_betID')->references('available_betID')->on('available_bets');
            $table->foreign('ticketID')->references('ticketID')->on('tickets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connection_available_bet_ticket');
    }
};
