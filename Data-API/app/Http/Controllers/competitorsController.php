<?php

namespace App\Http\Controllers;

use App\Models\competitorsModel;
use App\Models\teamsModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class competitorsController extends Controller
{
    public function getDataFrom($url)
    {
        $response = Http::get($url);

        return json_decode($response->body());
    }

    public function storeCompetitors()
    {
        $results = $this->getDataFrom('http://ergast.com/api/f1/current/last/results.json')->MRData->RaceTable->Races[0]->Results;
        $competitorsInfo = $this->getDataFrom('http://ergast.com/api/f1/current/drivers.json')->MRData->DriverTable->Drivers;

        foreach ($results as $key => $value) {
            $url = 'https://en.wikipedia.org/w/api.php?action=query&prop=extracts&exintro=1&explaintext=1&continue=&format=json&formatversion=2';
            $description = $this->getDataFrom($url . '&titles=' . substr($value->Constructor->url, 29))->query->pages[0]->extract;
            $removeFromDescription = Str::between($description, '(',')');
            $removeUnfinishedSentenceDesc = Str::afterLast($description, '.');          
            $description = Str::remove($removeFromDescription, $description);           
            $description = Str::remove($removeUnfinishedSentenceDesc, $description);            
            $description = Str::remove('()', $description);
            $cleanDescription = Str::squish($description);

            teamsModel::updateOrCreate(
                [
                    'name' => $value->Constructor->name,
                    'constructorUrl' => $value->Constructor->constructorId,
                    'description' => $cleanDescription == "" ? "No description was found." : $cleanDescription
                ]
            );
        }

        foreach ($results as $key => $value) {
            $url = 'https://en.wikipedia.org/w/api.php?action=query&prop=extracts&exintro=1&explaintext=1&continue=&format=json&formatversion=2';

            // Teljes név létrehozása

            $fullName = ($value->Driver->givenName . " " . $value->Driver->familyName);

            // Leírás lekérése és tisztítása
            $description = $this->getDataFrom($url . '&titles=' . substr($value->Driver->url, 29))->query->pages[0]->extract;

            $removeFromDescription = Str::between($description, '(',')');

            $removeUnfinishedSentenceDesc = Str::afterLast($description, '.');

            $description = Str::remove($removeFromDescription, $description);
            $description = Str::remove($removeUnfinishedSentenceDesc, $description);
            $description = Str::remove('()', $description);

            $cleanDescription = Str::squish($description);

            // Csapat név definiálása
            $teamName = $value->Constructor->name;

<<<<<<< Updated upstream

=======
>>>>>>> Stashed changes
            competitorsModel::updateOrCreate(
                [
                    'name' => $fullName,
                    'driverUrl' => $value->Driver->driverId,
                    'description' => $cleanDescription == "" ? "No description was found." : $cleanDescription,
                    'teamID' => teamsModel::where('name', 'LIKE', $teamName)->get()[0]->teamID
                ]
            );
        }
        foreach ($competitorsInfo as $key => $value) {

<<<<<<< Updated upstream
            
=======

            competitorsModel::updateOrCreate(
                [
                    'permanentNumber' =>,
                    'dateOfBirth' =>,
                    'nationality' =>
                ]
            );
>>>>>>> Stashed changes
        }
    }
}
