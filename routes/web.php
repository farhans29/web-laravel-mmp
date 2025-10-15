<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Archive\AjuController;
use App\Http\Controllers\Archive\DocumentController;
use App\Http\Controllers\Purchasing\PurchaseRequest\PurchaseRequestController;
use App\Http\Controllers\Warehouse\InventoryController;
use App\Http\Controllers\Master\Assets\MInventoryAssetController;
use App\Http\Controllers\Master\Department\DepartmentController;
use App\Http\Controllers\Master\DocumentType\DocumentTypeController;
use App\Http\Controllers\Master\Vendor\VendorController; // Ensure this class exists in the specified namespace


// Route::redirect('/', 'login');

Route::middleware(['guest'])->group(function () {
    Route::get('/', [SessionController::class, 'index'])->name('login');
    Route::post('/', [SessionController::class, 'login']);
});
Route::get('/home', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/warehouse/inventory', function () {
        return view('pages.warehouse.inventory.index_list');
    })->name('index.inventory');

    Route::get('/warehouse/inventoryNew', function () {
        return view('pages.warehouse.inventory.index_new');
    })->name('indexNew.inventory');

    Route::get('/warehouse/inventoryEdit', function () {
        return view('pages.warehouse.inventory.index_edit');
    })->name('indexEdit.inventory');

    ROute::get('/warehose/inventoryDelete', function () {
        return view('pages.warehouse.inventory.index_delete');
    })->name('indexDelete.inventory');
});
