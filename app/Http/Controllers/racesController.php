<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\racesModel;
use Illuminate\Http\Request;

class racesController extends Controller
{
    public static function storeRaces()
    {
        $races = competitorsController::getDataFrom('http://ergast.com/api/f1/current.json')->MRData->RaceTable->Races;

        // A szezonban lévő versenyek lekérése
        foreach ($races as $key => $value) {

            racesModel::updateOrCreate(
                [
                    'circuitName' => $value->Circuit->circuitName,
                    'circuitUrl' => $value->Circuit->circuitId,
                    'country' => $value->Circuit->Location->country,
                    'date' => $value->date == "" || null ? "No date is recorded" : $value->date
                ]
            );
        }
    }
}
