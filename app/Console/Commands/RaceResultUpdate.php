<?php

namespace App\Console\Commands;

use \App\Http\Controllers\raceResultsController;
use Illuminate\Console\Command;

class RaceResultUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'RaceResultUpdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Requests the most recent race results from the API.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function RaceResultUpdate()
    {
        try {
            raceResultsController::storeRaceScores();
            return Command::SUCCESS;
        } catch (\Throwable $th) {
            return Command::FAILURE;
        }
    }
}
