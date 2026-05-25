<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorController;

// Route untuk menerima data dari ESP8266
Route::post('/v1/sensor-data', [SensorController::class, 'store']);