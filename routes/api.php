<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::post('/signin', [AuthController::class, 'signin']);
    Route::group(['prefix' => '/trips', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', [TripController::class, 'index'])->name('api.v1.trips.index');
        Route::post('/', [TripController::class, 'store'])->name('api.v1.trips.store');
        Route::get('/{trip}', [TripController::class, 'show'])->name('api.v1.trips.show');
        Route::put('/{trip}', [TripController::class, 'update'])->name('api.v1.trips.update');
        Route::delete('/{trip}', [TripController::class, 'destroy'])->name('api.v1.trips.destroy');
    });
});