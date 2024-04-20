<?php

use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\Api\V1\Equipments\EquipmentController;
use App\Http\Controllers\Api\V1\Inspections\CategoryController;
use App\Http\Controllers\Api\V1\Status\StatusController;
use App\Http\Controllers\Api\V1\Trademarks\TrademarkController;
use App\Http\Controllers\Api\V1\Trademarks\TrademarkModelController;
use App\Http\Controllers\Api\V1\User\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//Login
Route::post('session/login', [SessionController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], static function () {
    //****************************** SESSION *******************************
    Route::get('session/user', static function (Request $request) {
        return $request->user();
    });
    Route::post('session/logout', [SessionController::class, 'logout']);
    //**************************** END SESSION *****************************
    //****************************** USER *******************************
    Route::resource('user', ApiController::class);
    //**************************** END USER *****************************
    //######################################################## INSPECTIONS #########################################################
    Route::resource('inspection/categories', CategoryController::class);
    //######################################################### EQUIPMENTS ##########################################################
    Route::resource('equipments', EquipmentController::class);
    Route::resource('equipment/categories', \App\Http\Controllers\Api\V1\Equipments\CategoryController::class);
    //######################################################### TRADEMARKS ##########################################################
    Route::resource('trademarks', TrademarkController::class);
    Route::resource('trademark/models', TrademarkModelController::class);
    //######################################################## INSPECTIONS ##########################################################
    Route::resource('inspection/categories', CategoryController::class);
    //######################################################### EQUIPMENTS ##########################################################
    Route::resource('status', StatusController::class);
});
