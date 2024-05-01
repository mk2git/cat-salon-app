<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReserveOptionController;
use App\Http\Controllers\ReserveCreateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/admin/dashboard', function () {
    return view('admin-dashboard');
})->middleware(['auth', 'can:admin', 'verified'])->name('admin.dashboard');

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
        Route::post('course', 'store')->name('course.store');
        Route::put('course/{id}', 'update')->name('course.update');
    });
    Route::controller(ReserveCreateController::class)->group(function(){
        Route::get('reserve/create', 'index')->name('reserveCreate.index');
        Route::post('reserve/create', 'store')->name('reserveCreate.store');
    });
    Route::controller(ReserveOptionController::class)->group(function(){
        Route::get('reserve/option', 'index')->name('option.index');
        Route::post('reserve/option', 'store')->name('option.store');
    });
});