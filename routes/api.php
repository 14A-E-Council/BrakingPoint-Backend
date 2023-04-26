<?php

use App\Http\Controllers\BetController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/bets/{id}', [BetController::class, 'show']);
Route::resource('bets', BetController::class)->except(['create', 'edit', 'show']);


Route::get('/tickets/{id}', [TicketController::class, 'show']);
Route::resource('tickets', TicketController::class)->except(['create', 'edit', 'show']);


Route::get('/users/{id}',[UserController::class, 'show']);
Route::resource('users', UserController::class)->except(['create', 'edit', 'show']);


Route::get('/sports/{id}', [SportController::class, 'show']);
Route::resource('sports', SportController::class)->except(['create', 'edit', 'show']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/auth/logout',[AuthController::class,'logout']);    
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
