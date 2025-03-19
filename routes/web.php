<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\BarangController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// User Routes
Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::post('/list', [UserController::class, 'list'])->name('user.list');
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/', [UserController::class, 'store'])->name('user.store');
    Route::get('/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});

// Level Routes
Route::get('/level', [LevelController::class, 'index'])->name('level.index');
Route::get('/level/list', [LevelController::class, 'list'])->name('level.list');

// Kategori Routes
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/list', [KategoriController::class, 'list'])->name('kategori.list');

// Stok Routes
Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
Route::get('/stok/list', [StokController::class, 'list'])->name('stok.list');

// Barang Routes
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/list', [BarangController::class, 'list'])->name('barang.list');
