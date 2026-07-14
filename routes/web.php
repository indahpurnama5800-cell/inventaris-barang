<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Halaman login — hanya bisa diakses saat belum login
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
});

// Seluruh halaman sistem WAJIB login
Route::middleware('auth')->group(function () {

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
    Route::put('profile/password/update', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('profile/activity', [ProfileController::class, 'activity'])->name('profile.activity');

    // CRUD Barang + Import/Export + Search/Filter
    Route::get('items/export/excel', [ItemController::class, 'exportExcel'])->name('items.export.excel');
    Route::get('items/export/csv', [ItemController::class, 'exportCsv'])->name('items.export.csv');
    Route::post('items/import', [ItemController::class, 'import'])->name('items.import');
    Route::resource('items', ItemController::class);

    // CRUD Kategori
    Route::resource('categories', CategoryController::class);

    // CRUD Supplier
    Route::resource('suppliers', SupplierController::class);

    // CRUD Transaksi
    Route::resource('transactions', TransactionController::class);

    // Audit Log
    Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
});
