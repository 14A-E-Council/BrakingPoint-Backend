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
use Illuminate\Support\Facades\Facade\Http;

use App\Http\Controllers\BetController;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

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
});

//Ban user
Route::group(['middleware'=>'is-ban'], function(){

    Route::post('userBan',[AdminController::class,'modifyOrDeleteUser'])->name('users.ban');
    Route::get('userUserRevoke/{id}',[UserController::class,'modifyOrDeleteUser'])->name('users.revokeuser');

});

//Teams/Competitors
Route::get('/storecompetitors', [competitorsController::class, 'storeCompetitors']);
Route::get('/storecurrentstandings', [currentStandingsController::class, 'storeCurrentStandings']);
Route::get('/storelastrace', [raceResultsController::class, 'storeLastRace']);

//Bets
Route::get('/bets/{id}', [BetController::class, 'show']);
Route::resource('bets', BetController::class)->except(['create', 'edit', 'show']);

//Tickets
Route::get('/tickets/{id}', [TicketController::class, 'show']);
Route::resource('tickets', TicketController::class)->except(['create', 'edit', 'show']);