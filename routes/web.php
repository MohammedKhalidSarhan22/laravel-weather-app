<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\WeatherController;

Route::get('/weather', [WeatherController::class, 'show'])->name('weather.show');
