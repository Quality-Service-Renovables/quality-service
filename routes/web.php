<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\V1\AppsController;
use App\Http\Controllers\Api\V1\Oils\OilController;
use App\Http\Controllers\Api\V1\Clients\ClientController;
use App\Http\Controllers\Api\V1\AuthGuards\RoleController;
use App\Http\Controllers\Api\V1\Failures\FailureController;
use App\Http\Controllers\Api\V1\Equipments\CategoryController;
use App\Http\Controllers\Api\V1\Equipments\EquipmentController;
use App\Http\Controllers\Api\V1\Trademarks\TrademarkController;
use App\Http\Controllers\Api\V1\AuthGuards\RolePermissionController;
use App\Http\Controllers\Api\V1\Trademarks\TrademarkModelController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Apps');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //Equipments
    Route::get('/equipments', [EquipmentController::class, 'component'])->name('equipments');
    //Equipments category
    Route::get('/equipments-categories', [CategoryController::class, 'component'])->name('ct_equipments');
    //Trademarks
    Route::get('/trademarks', [TrademarkController::class, 'component'])->name('trademaks');
    //Models
    Route::get('/models', [TrademarkModelController::class, 'component'])->name('models');
    //Oils
    Route::get('/oils', [OilController::class, 'component'])->name('oils');
    //Failures
    Route::get('/failures', [FailureController::class, 'component'])->name('failures');
    //Failures
    Route::get('/customers', [ClientController::class, 'component'])->name('clients');
    //Roles
    Route::get('/roles-permissions', [RolePermissionController::class, 'component'])->name('roles');
});

require __DIR__.'/auth.php';
