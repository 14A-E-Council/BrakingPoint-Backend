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

    public function store()
    {
        $results = $this->getDataFrom('http://ergast.com/api/f1/current/last/results.json')->MRData->RaceTable->Races[0]->Results;


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
                    'description' => $cleanDescription == "" ? "No description was found." : $cleanDescription

                ]
            );
        }
        // return;

        foreach ($results as $key => $value) {
            $url = 'https://en.wikipedia.org/w/api.php?action=query&prop=extracts&exintro=1&explaintext=1&continue=&format=json&formatversion=2';
            $fullName = ($value->Driver->givenName . " " . $value->Driver->familyName);
            $description = $this->getDataFrom($url . '&titles=' . substr($value->Driver->url, 29))->query->pages[0]->extract;
            $removeFromDescription = Str::between($description, '(',')');
            $removeUnfinishedSentenceDesc = Str::afterLast($description, '.');
            $description = Str::remove($removeFromDescription, $description);
            $description = Str::remove($removeUnfinishedSentenceDesc, $description);
            $description = Str::remove('()', $description);
            $cleanDescription = Str::squish($description);

            $teamName = $value->Constructor->name;

            // dd(teamsModel::where('name', 'LIKE', $teamName)->get()[0]->teamID);

            competitorsModel::updateOrCreate(
                [
                    'name' => $fullName,
                    'description' => $cleanDescription == "" ? "No description was found." : $cleanDescription,
                    'teamID' => teamsModel::where('name', 'LIKE', $teamName)->get()[0]->teamID
                ]
            );

            // dd($newCompetitor);
        }
    }
}
