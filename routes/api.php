<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\Api\V1\Oils\OilController;
use App\Http\Controllers\Api\V1\Users\UserController;
use App\Http\Controllers\Api\V1\Status\StatusController;
use App\Http\Controllers\Api\V1\Clients\ClientController;
use App\Http\Controllers\Api\V1\AuthGuards\RoleController;
use App\Http\Controllers\Api\V1\Failures\FailureController;
use App\Http\Controllers\Api\V1\Inspections\FormController;
use App\Http\Controllers\Api\V1\Inspections\RiskController;
use App\Http\Controllers\Api\V1\Projects\ProjectController;
use App\Http\Controllers\Api\V1\Projects\EmployeeController;
use App\Http\Controllers\Api\V1\Inspections\SectionController;
use App\Http\Controllers\Api\V1\Equipments\EquipmentController;
use App\Http\Controllers\Api\V1\Inspections\CategoryController;
use App\Http\Controllers\Api\V1\Inspections\EvidenceController;
use App\Http\Controllers\Api\V1\Trademarks\TrademarkController;
use App\Http\Controllers\Api\V1\AuthGuards\PermissionController;
use App\Http\Controllers\Api\V1\Inspections\InspectionController;
use App\Http\Controllers\Api\V1\AuthGuards\RolePermissionController;
use App\Http\Controllers\Api\V1\Trademarks\TrademarkModelController;
use App\Http\Controllers\Api\V1\Inspections\Reports\ReportController;
use App\Http\Controllers\Api\V1\Inspections\Resources\ResourceController;

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
    Route::resource('users', UserController::class);
    Route::get('users/get-rol-users/{rol_user}', [UserController::class, 'getRolUsers']);
    Route::post('users/update/{uuid}', [UserController::class, 'update']);
    Route::post('users/update-picture/{uuid}', [UserController::class, 'updatePicture']);
    //**************************** END USER *****************************
    //######################################################### CLIENTS ##########################################################
    Route::resource('clients', ClientController::class);
    Route::post('clients/update/{uuid}', [ClientController::class, 'update']);
    //######################################################## PROJECTS #########################################################
    Route::resource('projects', ProjectController::class);
    Route::resource('project/employees', EmployeeController::class);
    //######################################################## INSPECTIONS #########################################################
    Route::resource('inspections', InspectionController::class);
    Route::resource('inspection/sections', SectionController::class);
    Route::resource('inspection/equipments', \App\Http\Controllers\Api\V1\Inspections\EquipmentController::class)
        ->names('inspection.equipments');
    Route::resource('inspection/evidences', EvidenceController::class);
    Route::put('inspection/evidence/positions', [EvidenceController::class, 'positions']);
    Route::resource('inspection/categories', CategoryController::class)
        ->names('inspection.categories');

    Route::post('inspection/evidences/update/{uuid}', [EvidenceController::class, 'update']);
    Route::get('inspection/resources/get-inspection-details/{ct_inspection_uuid}', [ResourceController::class, 'getInspectionDetail'])
        ->name('inspection.resources.get-inspection-details');

    Route::get('inspection/get-document/{inspection_uuid}', [ReportController::class, 'getDocument'])
        ->name('inspection.resources.get-document');
    //---------------------------------------------------------   FORMS    ----------------------------------------------------------
    Route::get('inspection/forms/get-form/{ct_inspection_uuid}', [FormController::class, 'getForm']);
    Route::get('inspection/forms/get-form-inspection/{inspection_uuid}', [FormController::class, 'getFormInspection']);
    Route::post('inspection/forms/set-form', [FormController::class, 'setForm']);
    Route::post('inspection/forms/set-form-inspection', [FormController::class, 'setFormInspection']);

    Route::post('inspection/forms/set-form-fields', [FormController::class, 'setFormFields']);
    Route::put('inspection/forms/update-form-field/{uuid}', [FormController::class, 'updateFormField']);
    Route::delete('inspection/forms/delete-form-field/{uuid}', [FormController::class, 'deleteFormField']);
    //######################################################### EQUIPMENTS ##########################################################
    Route::resource('equipments', EquipmentController::class);
    // Para envio de tipo multi form, el verbo PUT no es compatible, se ha remplazado por la llamada a este end point
    Route::post('equipments/update/{uuid}', [EquipmentController::class, 'update']);
    Route::resource('equipment/categories', \App\Http\Controllers\Api\V1\Equipments\CategoryController::class)
        ->names('equipment.categories');
    //######################################################### OILS ##########################################################
    Route::resource('oils', OilController::class);
    Route::resource('oil/categories', \App\Http\Controllers\Api\V1\Oils\CategoryController::class)
        ->names('oil.categories');
    //######################################################### TRADEMARKS ##########################################################
    Route::resource('trademarks', TrademarkController::class);
    Route::resource('trademark/categories', \App\Http\Controllers\Api\V1\Trademarks\CategoryController::class)
        ->names('trademark.categories');
    Route::resource('trademark/models', TrademarkModelController::class);
    //----------------------------------------------------- Trademarks Resources ----------------------------------------------------
    Route::get('trademarks/get-category/{category}', [TrademarkController::class, 'getCategory'])->where(['category' => '[0-9]+']);
    //######################################################### EQUIPMENTS ##########################################################
    Route::resource('status', StatusController::class);
    //----------------------------------------------------- Failure Equipments ----------------------------------------------------
    Route::resource('failures', FailureController::class);
    Route::resource('failure/categories', \App\Http\Controllers\Api\V1\Failures\CategoryController::class)
        ->names('failure.categories');
    //######################################################## AUTH GUARDS ##########################################################
    Route::resource('auth-guard/roles', RoleController::class);
    Route::resource('auth-guard/permissions', PermissionController::class);
    Route::get('auth-guard/permissions-grouped', [PermissionController::class, 'grouped']);
    Route::resource('auth-guard/role-permissions', RolePermissionController::class);

    Route::resource('risks', RiskController::class);
});
