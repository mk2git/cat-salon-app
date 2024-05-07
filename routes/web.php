<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReserveOptionController;
use App\Http\Controllers\ReserveCreateController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});
// Route::get('/admin/dashboard', function () {
//     return view('admin-dashboard');
// })->middleware(['auth', 'can:admin', 'verified'])->name('admin.dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::controller(CourseController::class)->group(function(){
        Route::get('course', 'index')->name('course.index');
        // Route::get('/course/{id}', [CourseController::class, 'show']);

        Route::post('course', 'store')->name('course.store');
        Route::put('course/{id}', 'update')->name('course.update');
    });
    Route::controller(ReserveCreateController::class)->group(function(){
        Route::get('reserve/create', 'index')->name('reserveCreate.index');
        Route::post('reserve/create', 'store')->name('reserveCreate.store');
        Route::get('reserve/create/edit/{id}', 'edit')->name('reserveCreate.edit');
    });
    
    Route::get('option', [ReserveOptionController::class, 'index'])->name('reserve-option.index');
    Route::post('option', [ReserveOptionController::class, 'store'])->name('reserve-option.store');
    Route::put('option/{id}', [ReserveOptionController::class, 'update'])->name('reserve-option.update');
    Route::delete('option/{id}', [ReserveOptionController::class, 'destroy'])->name('reserve-option.delete');

    // Route::get('reserve/calendar', [CalendarController::class, 'index']);
});
