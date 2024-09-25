<?php

use App\Http\Controllers\v1\BatchUserUpdateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['throttle:3600,60'])->group(function () {
    // Route::post('/api/fake/provider/individual', [..., ...]);
});

Route::middleware(['throttle:50,60'])->group(function () {
    Route::post('/api/fake/provider/batch', [BatchUserUpdateController::class, 'updateBatchUsers'])->name('fake_api_batch');
});
