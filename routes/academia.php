<?php

use Illuminate\Support\Facades\Route;
//auth
Route::middleware('guest')->group(function () {
});

//auth
Route::middleware('auth')->group(function () {
});
