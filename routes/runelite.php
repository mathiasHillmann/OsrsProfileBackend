<?php

use App\Http\Controllers\RuneliteController;
use App\Http\Middleware\RuneliteMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(RuneliteController::class)->middleware(RuneliteMiddleware::class)->group(function () {
    Route::get('/player/{accountHash}', 'load');
    Route::post('/player/{accountHash}', 'submit');
    Route::post('/player/{accountHash}/model', 'model');
});
