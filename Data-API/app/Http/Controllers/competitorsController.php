<?php

namespace App\Http\Controllers;

use App\Models\competitorsModel;
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
                $fullName = ($value->givenName . "_" . $value->familyName);

                switch ($fullName) {
                    case 'Alexander_Albon':
                        $description = $this->getDataFrom($url . '&titles=' . 'Alex_Albon')->query->pages[0]->extract;
                        break;

                    case 'George_Russell':
                        $description = $this->getDataFrom($url . '&titles=' . 'George_Russell_(racing_driver)')->query->pages[0]->extract;
                        break;

                    case 'Carlos_Sainz':
                        $description = $this->getDataFrom($url . '&titles=' . 'Carlos_Sainz_Jr.')->query->pages[0]->extract;
                        break;

                    case 'Guanyu_Zhou':
                        $description = $this->getDataFrom($url . '&titles=' . 'Zhou_Guanyu')->query->pages[0]->extract;
                        break;

                    default:
                    $description = $this->getDataFrom($url . '&titles=' . $fullName)->query->pages[0]->extract;
                }

                competitorsModel::updateOrCreate(
                    [
                        'name' => str_replace('_', ' ', $fullName),
                        'description' => $description == "" ? "No description was found." : $description,
                        'teamId' => "No teamId yet"
                    ]
                );
            }
        }
    }
}
