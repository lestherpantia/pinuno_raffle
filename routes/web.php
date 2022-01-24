<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\RaffleController::class, 'index']);
Route::get('winners/{setid}', [\App\Http\Controllers\RaffleController::class, 'winners']);
Route::post('markAsWinner', [\App\Http\Controllers\RaffleController::class, 'markAsWinner']);

Route::get('settings', [\App\Http\Controllers\SettingController::class, 'index']);
Route::post('addset', [\App\Http\Controllers\SettingController::class, 'addset']);



Route::get('import', [\App\Http\Controllers\ImportController::class, 'index']);
Route::post('import/data', [\App\Http\Controllers\ImportController::class, 'importData']);
