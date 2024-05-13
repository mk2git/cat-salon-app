<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReserveOptionController;
use App\Http\Controllers\ReserveCreateController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});


Route::middleware(['auth', 'verified'])->group(function(){
    Route::controller(DashboardController::class)->group(function(){
        Route::get('/dashboard', 'index')->name('dashboard');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::controller(CourseController::class)->group(function(){
        Route::get('course', 'index')->name('course.index');
        Route::post('course', 'store')->name('course.store');
        Route::get('course/{id}', 'edit')->name('course.edit');
        Route::put('course/edit/{id}', 'update')->name('course.update');
        Route::delete('course/{id}', 'destroy')->name('course.destroy');
    });
    Route::controller(ReserveCreateController::class)->group(function(){
        Route::get('reserve/create', 'index')->name('reserveCreate.index');
        Route::get('reserve/status', 'showStatus')->name('reserveCreate.status');
        Route::get('reserve/status/{id}', 'showStatusDetail')->name('reserveCreate.showDetail');
        Route::post('reserve/create', 'store')->name('reserveCreate.store');
        Route::get('reserve/create/edit/{id}', 'edit')->name('reserveCreate.edit');
        Route::put('reserve/create/edit/{id}', 'update')->name('reserveCreate.update');
        Route::delete('reserve/create/edit/{id}', 'destroy')->name('reserveCreate.destroy');
    });
    
    Route::get('option', [ReserveOptionController::class, 'index'])->name('reserve-option.index');
    Route::post('option', [ReserveOptionController::class, 'store'])->name('reserve-option.store');
    Route::put('option/{id}', [ReserveOptionController::class, 'update'])->name('reserve-option.update');
    Route::delete('option/{id}', [ReserveOptionController::class, 'destroy'])->name('reserve-option.delete');

    Route::controller(ReserveController::class)->group(function(){
        Route::get('reserve', 'index')->name('reserve.index');
        Route::get('reserve/{id}', 'create')->name('reserve.create');
        Route::post('reserve', 'store')->name('reserve.store');
        Route::get('reserve/edit/{reserve_id}', 'edit')->name('reserve.edit');
        Route::put('reserve/edit/{reserve_id}', 'cancel')->name('reserve.cancel');
    });

    Route::controller(UserController::class)->group(function(){
        Route::get('user', 'index')->name('user.index');
    });

    Route::controller(RecordController::class)->group(function(){
        Route::get('record/{reserve_id}', 'create')->name('record.create');
    });
    

});
