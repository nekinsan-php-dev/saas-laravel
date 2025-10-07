<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceSettingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/clients', ClientController::class);
    Route::apiResource('/products', ProductController::class);
    
    Route::get('/invoice-settings',[InvoiceSettingController::class, 'index']);
    Route::post('/invoice-settings',[InvoiceSettingController::class, 'store']);
});
