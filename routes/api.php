<?php

use App\Http\Controllers\ApiMNCController;
use App\Http\Controllers\ApiTestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/api-mnc', [ApiMNCController::class, 'index']);
Route::post('/api-test', [ApiTestController::class, 'index']);