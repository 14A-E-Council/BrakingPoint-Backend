<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\competitorsModel;
use App\Models\raceResultsModel;
use App\Models\racesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class raceResultsController extends Controller
{
    public static function storeRaceScores()
    {
        $lastRaceResults = competitorsController::getDataFrom('http://ergast.com/api/f1/current/last/results.json')->MRData->RaceTable->Races[0];

        // A legutóbbi forduló adatainak a feltöltése adatbázisba versenyzőnként
        foreach ($lastRaceResults->Results as $key => $value) {

            raceResultsModel::updateOrCreate(
                [
                    'raceName' => $lastRaceResults->raceName,
                    'name' => $value->Driver->givenName . " " . $value->Driver->familyName,
                    'position' => $value->position,
                    'points' => $value->points,
                    'fastestLap' => $value->FastestLap->Time->time,
                    'laps' => $value->laps,
                    'date' => $lastRaceResults->date,
                    'competitorID' => competitorsModel::where('driverUrl', 'LIKE', $value->Driver->driverId)->get()[0]->competitorID,
                    'circuitID' => racesModel::where('circuitUrl', 'LIKE', $lastRaceResults->Circuit->circuitId)->get()[0]->raceID
                ]
            );
        }
    }
    public static function getLastRaceTopCompetitors()
    {
        return DB::table('raceresults')->orderBy('position')->orderBy('date')->limit(5)->get();
    }
}
