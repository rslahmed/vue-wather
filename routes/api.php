<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/weather/{lat}/{lon}', function (){
    $apiKey = config('services.weather.key');
    $lat = request()->lat;
    $lon = request()->lon;
   $response =  \Illuminate\Support\Facades\Http::get("https://api.weatherapi.com/v1/forecast.json?key=$apiKey&q=$lat,$lon&days=5");

   return $response->json();
});
