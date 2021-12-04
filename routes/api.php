<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\FlightController;

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
Route::post('/login', [AuthController::class, 'login'])->name("api.login");


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name("api.logout");
    Route::resource('/airports', AirportController::class)->except(["create","edit"]);
    Route::resource('/airlines', AirlineController::class)->except(["create","edit"]);
    Route::resource('/flights', FlightController::class)->except(["create","edit"]);

});