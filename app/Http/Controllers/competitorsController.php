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
        $lastRaceResults = $this->getDataFrom('http://ergast.com/api/f1/current/last/results.json')->MRData->RaceTable->Races[0]->Results;

        // Teamek adatainak a formázása, feltöltése adatbázisba
        foreach ($lastRaceResults as $key => $value) {
            $url = 'https://en.wikipedia.org/w/api.php?action=query&prop=extracts&exintro=1&explaintext=1&continue=&format=json&formatversion=2';
            // Leírás lekérése és tisztítása
            $description = $this->getDataFrom($url . '&titles=' . substr($value->Constructor->url, 29))->query->pages[0]->extract;
             // -Zárójeles részletek definiálása
            $removeFromDescription = Str::between($description, '(',')');
            // -Befejezetlen utolsó mondat definiálása
            $removeUnfinishedSentenceDesc = Str::afterLast($description, '.');
            // -Definiált leírás részletek és üres területek eltávolítása
            $description = Str::remove($removeFromDescription, $description);
            $description = Str::remove($removeUnfinishedSentenceDesc, $description);
            $description = Str::remove('()', $description);
            $cleanDescription = Str::squish($description);

            teamsModel::updateOrCreate(
                [
                    'name' => $value->Constructor->name,
                    'teamUrl' => $value->Constructor->constructorId,
                    'nationality' => $value->Constructor->nationality,
                    'description' => $cleanDescription == "" ? "No description was found." : $cleanDescription
                ]
            );
        }

        // Versenyzők adatainak formázása, feltöltése adatbázisba
        foreach ($lastRaceResults as $key => $value) {
            $url = 'https://en.wikipedia.org/w/api.php?action=query&prop=extracts&exintro=1&explaintext=1&continue=&format=json&formatversion=2';
            // Teljes név létrehozása
            $fullName = ($value->Driver->givenName . " " . $value->Driver->familyName);
            // Leírás lekérése
            $description = $this->getDataFrom($url . '&titles=' . substr($value->Driver->url, 29))->query->pages[0]->extract;
            // -Zárójeles részletek definiálása
            $removeFromDescription = Str::between($description, '(',')');
            // -Befejezetlen utolsó mondat definiálása
            $removeUnfinishedSentenceDesc = Str::afterLast($description, '.');
            // -Definiált leírás részletek és üres területek eltávolítása
            $description = Str::remove($removeFromDescription, $description);
            $description = Str::remove($removeUnfinishedSentenceDesc, $description);
            $description = Str::remove('()', $description);
            $cleanDescription = Str::squish($description);

            competitorsModel::updateOrCreate(
                [
                    'name' => $fullName,
                    'driverUrl' => $value->Driver->driverId,
                    'dateOfBirth' => $value->Driver->dateOfBirth,
                    'permanentNumber' =>$value->Driver->permanentNumber,
                    'nationality' => $value->Driver->nationality,
                    'description' => $cleanDescription == "" ? "No description was found." : $cleanDescription,
                    'teamID' => teamsModel::where('teamUrl', 'LIKE', $value->Constructor->constructorId)->get()[0]->teamID
                ]
            );
        }
    }
}
