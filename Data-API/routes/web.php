<?php

use App\Http\Controllers\competitorsController;
use App\Http\Controllers\raceResultsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Facade\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/storecompetitors', [competitorsController::class, 'storeCompetitors']);
Route::get('/updatecompetitors', [competitorsController::class, 'updateCompetitors']);
Route::get('/storelastrace', [raceResultsController::class, 'storeLastRace']);
