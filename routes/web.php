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
    Route::get('/', [UserController::class, 'index'])->name('user.index'); // Display all users
    Route::get('/create', [UserController::class, 'create'])->name('user.create'); // Show form to create user
    Route::post('/', [UserController::class, 'store'])->name('user.store'); // Store new user
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);
    Route::post('/ajax', [UserController::class, 'store_ajax']);
    Route::get('/{id}', [UserController::class, 'show'])->name('user.show'); // Show user details
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit'); // Show form to edit user
    Route::put('/{id}', [UserController::class, 'update'])->name('user.update'); // Update user details
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // Menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax  
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy'); // Delete user
    Route::post('/list', [UserController::class, 'list'])->name('user.list'); // For fetching user list (Ajax)
});

// Level Routes
Route::prefix('level')->group(function () {
    Route::resource('level', LevelController::class);

    Route::get('/', [LevelController::class, 'index'])->name('level.index'); // Display all levels
    Route::get('/list', [LevelController::class, 'list'])->name('level.list'); // Fetch level list (Ajax)
    Route::get('/create', [LevelController::class, 'create'])->name('level.create'); // Show form to create level
    Route::post('/', [LevelController::class, 'store'])->name('level.store'); // Store new level
    Route::get('/{id}', [LevelController::class, 'show'])->name('level.show'); // Show level details
    Route::get('/{id}/edit', [LevelController::class, 'edit'])->name('level.edit'); // Show form to edit level
    Route::put('/{id}', [LevelController::class, 'update'])->name('level.update'); // Update level details
    Route::delete('/{id}', [LevelController::class, 'destroy'])->name('level.destroy'); // Delete level
});

// Kategori Routes
// Kategori Routes (update jika perlu)
Route::prefix('kategori')->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/list', [KategoriController::class, 'list'])->name('kategori.list'); // Fetch categories list (Ajax)
    Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/{id}', [KategoriController::class, 'show'])->name('kategori.show');
    Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
});


// Stok Routes
Route::prefix('stok')->group(function () {
    Route::get('/', [StokController::class, 'index'])->name('stok.index');
    Route::get('/list', [StokController::class, 'list'])->name('stok.list');
    Route::get('/create', [StokController::class, 'create'])->name('stok.create');
    Route::post('/', [StokController::class, 'store'])->name('stok.store');
    Route::get('/{id}/edit', [StokController::class, 'edit'])->name('stok.edit');
    Route::put('/{id}', [StokController::class, 'update'])->name('stok.update');
    Route::delete('/{id}', [StokController::class, 'destroy'])->name('stok.destroy');
});


// Barang Routes
Route::prefix('barang')->group(function () {
    Route::get('/', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/list', [BarangController::class, 'list'])->name('barang.list'); // Corrected route
    Route::get('/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/{id}', [BarangController::class, 'show'])->name('barang.show');
    Route::get('/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
});
