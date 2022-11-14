<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\competitorstest;
use Illuminate\Support\Facades\Http;
use stdClass;

class competitorsTestController extends Controller
{
    //
    public function store()
    {
        $api_url = 'http://ergast.com/api/f1/current/drivers.json';

        $response = Http::get($api_url);

        $data = json_decode($response->body());

        echo "<pre>";

        foreach ($data as $Competitorstest)
        {
            // $Competitorstest = (array)$Competitorstest;
            // $CompetitorsTest1 = (array)$Competitorstest['DriverTable'];
            $drivers = (((array)((array)$Competitorstest)['DriverTable'])['Drivers']);
            foreach ($drivers as $key => $value) {
                // dd($drivers);
                // dd($value);
                // dd($value->driverId);
                competitorstest::updateOrCreate(
                    [
                        'driverId' => $value->driverId,
                    'permanentNumber' => $value->permanentNumber,
                    'code' => $value->code,
                    'url' => $value->url,
                    'givenName' => $value->givenName,
                    'familyName' => $value->familyName,
                    'dateOfBirth' => $value->dateOfBirth,
                    'nationality' => $value->nationality]
                );
            }
        }

        // print_r($data);
        die;
    }
}
