<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\MatchController;

use App\Http\Controllers\ApiConnectionController;

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
    return view('home');
});

Route::get('/matches', function() { return view('matches.matches'); })->name('matches');

Route::get('/scraping', [ApiConnectionController::class, 'bt_scraping'])->name('scraping');

Route::get('/bets', [MatchController::class, 'index'])->name('bets');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
