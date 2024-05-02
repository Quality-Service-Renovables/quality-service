<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\V1\AppsController;
use App\Http\Controllers\Api\V1\Oils\OilController;
use App\Http\Controllers\Api\V1\Equipments\CategoryController;
use App\Http\Controllers\Api\V1\Equipments\EquipmentController;
use App\Http\Controllers\Api\V1\Trademarks\TrademarkController;
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
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //Apps
    Route::get('/apps', [AppsController::class, 'component'])->name('apps');
    //Equipments
    Route::get('/equipments', [EquipmentController::class, 'component'])->name('equipments');
    //Equipments category
    Route::get('/equipments-categories', [CategoryController::class, 'component'])->name('equipment_categories');
    //Trademarks
    Route::get('/trademarks', [TrademarkController::class, 'component'])->name('trademaks');
    //Models
    Route::get('/models', [TrademarkModelController::class, 'component'])->name('models');
    //Oils
    Route::get('/oils', [OilController::class, 'component'])->name('oils');
});

require __DIR__.'/auth.php';
