<?php

use App\Engine\Engine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptoController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/filter', [CryptoController::class, 'filter_date']);

Route::get('/offday', [CryptoController::class, 'offdaystatus']);
Route::get('/luckynumber_history', [CryptoController::class, 'luckynumber_history']);
Route::get('/test', [CryptoController::class, 'test']);


