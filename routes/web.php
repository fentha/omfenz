<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/aktivitas-anak', 'aktivitas-anak');
Route::redirect('/worksheet-anak', '/aktivitas-anak');
