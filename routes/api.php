<?php

use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\Api\V1\Inspections\CategoryController;
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
    Route::resource('inspection-categories', CategoryController::class);
});
