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
        foreach ($this->getDataFrom('http://ergast.com/api/f1/current/drivers.json') as $Competitors) {
            $drivers = (((array) ((array) $Competitors)['DriverTable'])['Drivers']);
            foreach ($drivers as $key => $value) {
                $url = 'https://en.wikipedia.org/w/api.php?action=query&prop=extracts&exintro=1&explaintext=1&continue=&format=json&formatversion=2';
                $fullName = ($value->givenName . " " . $value->familyName);
                $description = $this->getDataFrom($url . '&titles=' . substr($value->url, 29))->query->pages[0]->extract;

                competitorsModel::updateOrCreate(
                    [
                        'name' => $fullName,
                        'description' => $description == "" ? "No description was found." : $description,
                        'teamId' => ""
                    ]
                );
            }
        }
        foreach ($this->getDataFrom('http://ergast.com/api/f1/current/constructors.json') as $Teams) {
            $constructors = (((array) ((array) $Competitors)['DriverTable'])['Drivers']);
            foreach ($constructors as $key => $value) {
                $url = 'https://en.wikipedia.org/w/api.php?action=query&prop=extracts&exintro=1&explaintext=1&continue=&format=json&formatversion=2';
                $description = $this->getDataFrom($url . '&titles=' . substr($value->url, 29))->query->pages[0]->extract;

                teamsModel::updateOrCreate(
                    [
                        'name' => $value->name,
                        'description' => $description == "" ? "No description was found." : $description,
                        'sportId' => "1"
                    ]
                );
            }
        }
    }
}
