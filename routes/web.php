<?php

use App\Engine\Engine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptoController;
use GuzzleHttp\Psr7\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/terms', function () {
    return view('terms');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/section', [App\Http\Controllers\DashboardController::class, 'section_view'])->name('section');
Route::get('/offdays', [App\Http\Controllers\DashboardController::class, 'offdays'])->name('offdays');
Route::post('/offdays', [App\Http\Controllers\DashboardController::class, 'createoffday'])->name('create-offdays');
Route::post('/delete-offday/{id}', [App\Http\Controllers\DashboardController::class, 'deleteoffday']);
Route::post('/section', [App\Http\Controllers\DashboardController::class, 'create_section']);
Route::post('/section-delete/{id}', [App\Http\Controllers\DashboardController::class, 'delete_section'])->name('delete_section');
Route::get('/manual', [App\Http\Controllers\DashboardController::class, 'manual_view'])->name('manual');
Route::post('/manual/{id}', [App\Http\Controllers\DashboardController::class, 'create_manual']);
Route::get('/logs', [App\Http\Controllers\DashboardController::class, 'log'])->name('logs');
Route::get('/live', [App\Http\Controllers\CryptoController::class, 'live']);
Route::get('/test', [App\Http\Controllers\CryptoController::class, 'test']);
Route::get('/fbdata', [App\Http\Controllers\CryptoController::class, 'test']);

Route::get('password', [App\Http\Controllers\Auth\ChangePasswordController::class, 'edit'])->name('passwordedit');
Route::post('password', [App\Http\Controllers\Auth\ChangePasswordController::class, 'update'])->name('passwordupdate');


