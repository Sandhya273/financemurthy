<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\chart;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/',[chart::class,'index']);
