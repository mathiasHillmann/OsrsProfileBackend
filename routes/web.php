<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', fn () => response()->json(['message' => 'Api for Osrprofile.com']));

Route::get('/test', function () {
    dd(Storage::allFiles());
});
