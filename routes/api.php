<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerification;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\FacebookController;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\competitorsController;
use App\Http\Controllers\raceResultsController;
use App\Http\Controllers\currentStandingsController;
use App\Http\Controllers\racesController;

use Illuminate\Support\Facades\Facade\Http;

use App\Http\Controllers\BetController;
use App\Http\Controllers\TicketController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Admin
Route::controller(AdminController::class)->group(function (){
    Route::get('/admin', 'showUsers');
    Route::put('/admin', 'modifyOrDeleteUser');
});

//Facebook
Route::controller(FacebookController::class)->group(function(){
    Route::get('auth/facebook', 'redirectToFacebook')->name('auth.facebook');
    Route::get('auth/facebook/callback', 'handleFacebookCallback');
});

//Google
Route::controller(GoogleController::class)->group(function(){
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

//User
Route::controller(UserController::class)->group(function () {
    Route::get('/leaderboard', 'showUsers');
    Route::put('/editprofile/{id}', 'edit');
    Route::put('/editpassword/{id}', 'editPassword');
});

//Ban user
Route::group(['middleware'=>'is-ban'], function(){

    Route::post('userBan',[AdminController::class,'modifyOrDeleteUser'])->name('users.ban');
    Route::get('userUserRevoke/{id}',[UserController::class,'modifyOrDeleteUser'])->name('users.revokeuser');

});

//Teams/Competitors külső forrásból való lekérése
Route::get('/storecompetitors', [competitorsController::class, 'storeCompetitors']);
Route::get('/storecurrentstandings', [currentStandingsController::class, 'storeCurrentStandings']);
Route::get('/storeracescores', [raceResultsController::class, 'storeRaceScores']);
Route::get('/storelastrace', [raceResultsController::class, 'storeLastRace']);
Route::get('/storecurrentseasonraces', [racesController::class, 'storeRaces']);

//Főoldalhoz tartozó API kérések
Route::get('/shownextrace', [racesController::class, 'showNextRace']);
Route::get('/gettopcompetitors', [competitorsController::class, 'getTopCompetitors']);
Route::get('/getlastracetopcompetitors', [raceResultsController::class, 'getLastRaceTopCompetitors']);

//Csapat felsorolás oldalhoz tartozó kérés
Route::get('/showallteams', [competitorsController::class, 'showAllTeams']);

//Csapat oldalakhoz tartozó API kérések
Route::get('/getteambyteamurl/{teamUrl}', [competitorsController::class, 'getTeamByTeamUrl']);
Route::get('/getdriverbyteamid/{teamID}', [competitorsController::class, 'getDriverByTeamID']);

//Vezető oldalakhoz tartozó API kérések
Route::get('/getdriverbydriverurl/{driverUrl}', [competitorsController::class, 'getDriverByDriverUrl']);
Route::get('/getteambyteamid/{teamID}', [competitorsController::class, 'getTeamByTeamID']);

//Bets
Route::get('/bets/{id}', [BetController::class, 'show']);
Route::resource('bets', BetController::class)->except(['create', 'edit', 'show']);

//Tickets
Route::get('/tickets/{id}', [TicketController::class, 'show']);
Route::resource('tickets', TicketController::class)->except(['create', 'edit', 'show']);