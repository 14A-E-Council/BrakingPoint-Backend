<?php

namespace App\Http\Controllers;

use App\Models\competitorsModel;
use App\Models\teamsModel;
use Illuminate\Support\Facades\Http;

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

            teamsModel::updateOrCreate(
                [
                    'name' => $value->Constructor->name,
                    'description' => $description == "" ? "No description was found." : $description

                ]
            );
        }
        // return;

        foreach ($results as $key => $value) {
            $url = 'https://en.wikipedia.org/w/api.php?action=query&prop=extracts&exintro=1&explaintext=1&continue=&format=json&formatversion=2';
            $fullName = ($value->Driver->givenName . " " . $value->Driver->familyName);
            $description = $this->getDataFrom($url . '&titles=' . substr($value->Driver->url, 29))->query->pages[0]->extract;

            $teamName = $value->Constructor->name;

            // dd(teamsModel::where('name', 'LIKE', $teamName)->get()[0]->teamID);

            competitorsModel::updateOrCreate(
                [
                    'name' => $fullName,
                    'description' => $description == "" ? "No description was found." : $description,
                    'teamID' => teamsModel::where('name', 'LIKE', $teamName)->get()[0]->teamID
                ]
            );

            // dd($newCompetitor);
        }
    }
}
