<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\InventoryController;

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
    // Inventory API Routes
    Route::prefix('inventory')->group(function () {
        Route::get('/', [InventoryController::class, 'index']);
        Route::post('/', [InventoryController::class, 'store']);
        Route::get('/{id}', [InventoryController::class, 'show']);
        Route::patch('/{id}', [InventoryController::class, 'update']);
        Route::delete('/{id}', [InventoryController::class, 'destroy']);
        Route::post('/{id}/soft-delete', [InventoryController::class, 'softDelete']);
    });
});
