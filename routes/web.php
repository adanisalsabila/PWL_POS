<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\BarangController;

route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/list', [UserController::class, 'list']);
    Route::get('/list', [UserController::class, 'list']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::get('/level', [LevelController::class, 'index'])->name('level.index');
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index'); // Tambahkan ini
Route::get('/supplier', [StokController::class, 'index'])->name('supplier.index'); // Tambahkan ini
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index'); // Tambahkan ini

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/level', [LevelController::class, 'dashboardLevel'])->name('dashboard.level');
    Route::get('/kategori', [KategoriController::class, 'dashboardKategori'])->name('dashboard.kategori');
    Route::get('/stok', [StokController::class, 'dashboardStok'])->name('dashboard.stok');
    Route::get('/barang', [BarangController::class, 'dashboardBarang'])->name('dashboard.barang');

    Route::post('/level/list', [LevelController::class, 'dashboardLevelList'])->name('dashboard.level.list');
    Route::post('/kategori/list', [KategoriController::class, 'dashboardKategoriList'])->name('dashboard.kategori.list');
    Route::post('/stok/list', [StokController::class, 'dashboardStokList'])->name('dashboard.stok.list');
    Route::post('/barang/list', [BarangController::class, 'dashboardBarangList'])->name('dashboard.barang.list');

    Route::post('/dashboard/kategori/list', [KategoriController::class, 'dashboardKategoriList'])->name('dashboard.kategori.list');
});