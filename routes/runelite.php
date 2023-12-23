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

Route::controller(RuneliteController::class)
    ->prefix('player')
    ->middleware(RuneliteMiddleware::class)
    ->group(function () {
        Route::get('/vars', 'load');
        Route::post('/{accountHash}', 'submit');
        Route::post('/{accountHash}/model', 'model');
    });
