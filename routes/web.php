<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/monitoring', function () {
    return view('monitoring');
});

Route::get('/contact', function () {
    return view('contact');
});