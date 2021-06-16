<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\TableroController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\FriendController;

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
    //--------------------------------------------------------------------------
    //-------------------------------------------------------Opciones de tarjeta
    Route::post('updateTarjetaCol', [TableroController::class, 'updateTarjetaCol']);
    Route::post('updateTarjetaPos', [TableroController::class, 'updateTarjetaPos']);

    Route::post('setTarjeta', [TableroController::class, 'setTarjeta']);
    Route::post('getTarjeta', [TableroController::class, 'getTarjeta']);
    Route::post('getTarjetas', [TableroController::class, 'getTarjetas']);
    Route::post('getTarjetasDate', [CalendarioController::class, 'getTarjetasDate']);
    Route::post('getTarjetaDate', [CalendarioController::class, 'getTarjetaDate']);
    //--------------------------------------------------------------------------

    //--------------------------------------------------------------------------
    //------------------------------------------------------opciones de tableros
    Route::post('getTableros', [TableroController::class, 'getTableros']);
    Route::post('getTablero', [TableroController::class, 'getTablero']);
    Route::post('setTableros', [TableroController::class, 'setTableros']);
    Route::post('dropTablero', [TableroController::class, 'dropTablero']);
    Route::post('updateTableroNombre', [TableroController::class, 'updateTablero']);
    
    Route::post('updateTarjeta', [TableroController::class, 'updateTarjeta']);
    Route::post('dropTarjeta', [TableroController::class, 'dropTarjeta']);
    
    Route::post('getColumna', [TableroController::class, 'getColumna']);
    Route::post('getColumnas', [TableroController::class, 'getColumnas']);
    Route::post('getColumnasfull', [TableroController::class, 'getColumnasfull']);
    Route::post('addColumna', [TableroController::class, 'addColumna']);
    Route::post('updateColumna', [TableroController::class, 'updateColumna']);
    Route::post('dropColumna', [TableroController::class, 'dropColumna']);
    Route::post('getUsersTablero', [TableroController::class, 'getUsersTablero']);
    Route::post('addUserTablero', [TableroController::class, 'addUserTablero']);
    
    //--------------------------------------------------------------------------
    
    //--------------------------------------------------------------------------
    //------------------------------------------------Opciones usuarios añadidos
    Route::post('getAllUsers', [FriendController::class, 'getAllUsers']);
    Route::post('getUsersNotFriends', [FriendController::class, 'getUsersNotFriends']);
    Route::post('getUsersAlmostFriends', [FriendController::class, 'getUsersAlmostFriends']);
    Route::post('getUsersFriends', [FriendController::class, 'getUsersFriends']);
    Route::put('putUserAmigo', [FriendController::class, 'putUserAmigo']);
    //--------------------------------------------------------------------------
    //--------------------------------------------------------------------------
    //----------------------------------------------------------Opciones usuario
    Route::post('mod_user', [AuthController::class, 'mod_user']);
    Route::post('cambiarFoto/{id}', [AuthController::class, 'cambiarFoto']);
    //--------------------------------------------------------------------------
});
    Route::put('mod_user_pass', [AuthController::class, 'mod_user_pass']);
