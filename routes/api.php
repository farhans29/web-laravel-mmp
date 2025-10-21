<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\InventoryController;
use App\Http\Controllers\API\SupplierController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Version 1 API Routes
Route::prefix('v1')->group(function () {
    
    // Authentication API Routes (Public)
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        // Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    
    // Authentication API Routes (Protected)
    // Route::prefix('auth')->middleware('auth:sanctum')->group(function () {
    // });
    
    // Inventory API Routes
    Route::prefix('inventory')->group(function () {
        Route::get('/', [InventoryController::class, 'index']);
        Route::post('/', [InventoryController::class, 'store']);
        Route::get('/{id}', [InventoryController::class, 'show']);
        Route::patch('/{id}', [InventoryController::class, 'update']);
        Route::delete('/{id}', [InventoryController::class, 'destroy']);
        Route::post('/{id}/soft-delete', [InventoryController::class, 'softDelete']);
    });
    
    // Supplier API Routes
    Route::prefix('supplier')->group(function () {
        Route::get('/', [SupplierController::class, 'index']);
        Route::post('/', [SupplierController::class, 'store']);
        Route::get('/{id}', [SupplierController::class, 'show']);
        Route::patch('/{id}', [SupplierController::class, 'update']);
        Route::delete('/{id}', [SupplierController::class, 'destroy']);
        Route::post('/{id}/soft-delete', [SupplierController::class, 'softDelete']);
    });
});

