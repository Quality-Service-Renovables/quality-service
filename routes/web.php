<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\V1\Oils\OilController;
use App\Http\Controllers\Api\V1\Users\UserController;
use App\Http\Controllers\Api\V1\Clients\ClientController;
use App\Http\Controllers\Api\V1\Failures\FailureController;
use App\Http\Controllers\Api\V1\Projects\ProjectController;
use App\Http\Controllers\Api\V1\Equipments\CategoryController;
use App\Http\Controllers\Api\V1\Equipments\EquipmentController;
use App\Http\Controllers\Api\V1\Trademarks\TrademarkController;
use App\Http\Controllers\Api\V1\Inspections\InspectionController;
use App\Http\Controllers\Api\V1\AuthGuards\RolePermissionController;
use App\Http\Controllers\Api\V1\Trademarks\TrademarkModelController;
use App\Http\Controllers\Api\V1\Inspections\Reports\ReportController;
use App\Http\Controllers\Api\V1\Inspections\CategoryController as InspectionCategoryController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/home', function () {
    return Inertia::render('Apps');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Equipments
    Route::group(['middleware' => ['permission:equipments']], function () {
        Route::get('/equipments', [EquipmentController::class, 'component'])->name('equipments');
    });

    //Equipments category
    Route::group(['middleware' => ['permission:equipments_categories']], function () {
        Route::get('/equipments-categories', [CategoryController::class, 'component'])->name('ct_equipments');
    });

    //Trademarks
    Route::group(['middleware' => ['permission:trademarks']], function () {
        Route::get('/trademarks', [TrademarkController::class, 'component'])->name('trademaks');
    });

    //Models
    Route::group(['middleware' => ['permission:models']], function () {
        Route::get('/models', [TrademarkModelController::class, 'component'])->name('models');
    });

     //Oils
    Route::group(['middleware' => ['permission:oils']], function () {
        Route::get('/oils', [OilController::class, 'component'])->name('oils');
    });

    //Failures
    Route::group(['middleware' => ['permission:failures']], function () {
        Route::get('/failures', [FailureController::class, 'component'])->name('failures');
    });

    //Clients
    Route::group(['middleware' => ['permission:clients']], function () {
        Route::get('/customers', [ClientController::class, 'component'])->name('clients');
    });

    //Roles and permissions
    Route::group(['middleware' => ['permission:roles']], function () {
        Route::get('/roles-permissions', [RolePermissionController::class, 'component'])->name('roles');
    });

    // Inspections categories
    Route::group(['middleware' => ['permission:inspections']], function () {
        Route::get('/inspections-categories', [InspectionCategoryController::class, 'component'])->name('inspections-categories');
    });

    //Projects
    Route::group(['middleware' => ['permission:projects']], function () {
        Route::get('/projects', [ProjectController::class, 'component'])->name('projects');
    });

    Route::get('/inspection/get-document/{uuid}', [ReportController::class, 'getDocument'])->name('document-get');

    //Users
    Route::group(['middleware' => ['permission:users']], function () {
        Route::get('/users', [UserController::class, 'component'])->name('users');
    });

});

require __DIR__.'/auth.php';
