<?php

use App\Http\Controllers\ServerController;
use Illuminate\Support\Facades\Route;

Route::apiResource('servers', ServerController::class);
Route::post('/servers/update-order', [ServerController::class, 'updateOrder']);

