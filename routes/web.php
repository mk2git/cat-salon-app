<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReserveOptionController;
use App\Http\Controllers\ReserveCreateController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StampController;
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
        Route::get('user/{id}', 'show')->name('user.show');
        Route::get('user/record/{reserve_id}', 'showRecord')->name('user.showRecord');
    });

    Route::controller(RecordController::class)->group(function(){
        Route::get('record/{reserve_id}', 'create')->name('record.create');
        Route::post('record', 'store')->name('record.store');
        Route::put('record', 'update')->name('record.update');
        Route::get('records/{user_id}' , 'getUserRecords')->name('record.userRecords');
    });

    Route::controller(CheckoutController::class)->group(function(){
        Route::get('checkout', 'index')->name('checkout.index');
        Route::get('checkout/{reserve_id}', 'edit')->name('checkout.edit');
        Route::put('checkout', 'update')->name('checkout.update');
        Route::get('checkout/{reserve_id}/{user_id}', 'showCheckout')->name('checkout.showCheckout');
        Route::put('checkout/updateCheckout', 'updateCheckout')->name('checkout.updateCheckout');

    });

    Route::controller(StampController::class)->group(function(){
        Route::get('stamp/{user_id}', 'show')->name('stamp.show');
    });
    

});
