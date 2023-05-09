<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\competitorsModel;
use App\Models\raceResultsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class raceResultsController extends Controller
{
    public function getDataFrom($url)
    {
        $response = Http::get($url);

        return json_decode($response->body());
    }
    public function storeRaceScores()
    {
        $lastRaceResults = $this->getDataFrom('http://ergast.com/api/f1/current/last/results.json')->MRData->RaceTable->Races[0];

        // A legutóbbi forduló adatainak a feltöltése adatbázisba versenyzőnként
        foreach ($lastRaceResults->Results as $key => $value) {

            raceResultsModel::updateOrCreate(
                [
                    'raceName' => $lastRaceResults->raceName,
                    'position' => $value->position,
                    'points' => $value->points,
                    'fastestLap' => $value->FastestLap->Time->time,
                    'laps' => $value->laps,
                    'date' => $lastRaceResults->date,
                    'competitorID' => competitorsModel::where('driverUrl', 'LIKE', $value->Driver->driverId)->get()[0]->competitorID
                ]
            );
        }
    }
}
