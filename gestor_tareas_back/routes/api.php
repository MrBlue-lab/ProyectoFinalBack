<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\TableroController;
use App\Http\Controllers\CalendarioController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('getTableros', [TableroController::class, 'getTableros']);
    Route::post('getTablero', [TableroController::class, 'getTablero']);
    Route::post('setTableros', [TableroController::class, 'setTableros']);

    Route::post('updateTarjetaCol', [TableroController::class, 'updateTarjetaCol']);
    Route::post('updateTarjetaPos', [TableroController::class, 'updateTarjetaPos']);

    Route::post('setTarjeta', [TableroController::class, 'setTarjeta']);
    Route::post('getTarjeta', [TableroController::class, 'getTarjeta']);
    Route::post('getTarjetas', [TableroController::class, 'getTarjetas']);
    Route::post('getTarjetasDate', [CalendarioController::class, 'getTarjetasDate']);
    Route::post('getTarjetaDate', [CalendarioController::class, 'getTarjetaDate']);

    Route::post('updateTarjeta', [TableroController::class, 'updateTarjeta']);
    Route::post('addColumna', [TableroController::class, 'addColumna']);
    Route::post('updateColumna', [TableroController::class, 'updateColumna']);
    Route::post('getColumna', [TableroController::class, 'getColumna']);
    Route::post('getColumnas', [TableroController::class, 'getColumnas']);
    Route::post('getColumnasfull', [TableroController::class, 'getColumnasfull']);
    Route::post('dropTarjeta', [TableroController::class, 'dropTarjeta']);
    Route::post('dropColumna', [TableroController::class, 'dropColumna']);
    Route::post('dropTablero', [TableroController::class, 'dropTablero']);
    Route::post('updateTableroNombre', [TableroController::class, 'updateTablero']);
});
Route::post('mod_user', [AuthController::class, 'mod_user']);
    Route::put('mod_user_pass', [AuthController::class, 'mod_user_pass']);
