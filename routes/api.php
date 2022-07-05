<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiConnectionController;
use App\Http\Controllers\Web\MatchController;

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

Route::get('/matches/{date}', [ApiConnectionController::class, 'matches_by_date'])->name('matches_by_date');
Route::get('/countries', [ApiConnectionController::class, 'get_countries'])->name('get_countries');

Route::post('/matches', [MatchController::class, 'store'])->name('matches.create');