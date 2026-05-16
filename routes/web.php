<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitoringController;

Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/hortikultura', function () {
    return view('hortikultura');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/monitoring', [MonitoringController::class, 'index']);
