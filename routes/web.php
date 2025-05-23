<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Route Parameter Pattern
Route::pattern('id', '[0-9]+');

// // Protected Routes (Requires Authentication)
// Route::middleware(['auth'])->group(function () {
    Route::get('/', [WelcomeController::class, 'index'])->name('welcome'); // Halaman utama setelah login

    // User Routes
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/', [UserController::class, 'store'])->name('user.store');
        Route::get('/{id}', [UserController::class, 'show'])->name('user.show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/user/import', [UserController::class, 'import'])->name('user.import');
Route::post('/user/import_ajax', [UserController::class, 'import_ajax'])->name('user.import_ajax');
Route::get('/user/export_excel', [UserController::class, 'export_excel'])->name('user.export_excel');
Route::get('/user/export_pdf', [UserController::class, 'export_pdf'])->name('user.export_pdf');


         // Route untuk menampilkan form registrasi
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');

// Route untuk memproses data registrasi (menggunakan method store pada UserController)
Route::post('/register', [UserController::class, 'storeRegistration'])->name('register.store');

        // Ajax Routes
        Route::get('/create_ajax', [UserController::class, 'create_ajax']);
        Route::post('/ajax', [UserController::class, 'store_ajax']);
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
        Route::post('/list', [UserController::class, 'list'])->name('user.list');
    });

    // // Level Routes
    // Route::middleware(['authorize:ADM'])->group(function () {
        Route::prefix('level')->group(function () {
        Route::get('/', [LevelController::class, 'index'])->name('level.index');
        Route::get('/create', [LevelController::class, 'create'])->name('level.create');
        Route::post('/', [LevelController::class, 'store'])->name('level.store');
        Route::get('/{id}', [LevelController::class, 'show'])->name('level.show');
        Route::get('/{id}/edit', [LevelController::class, 'edit'])->name('level.edit');
        Route::put('/{id}', [LevelController::class, 'update'])->name('level.update');
        Route::delete('/{id}', [LevelController::class, 'destroy'])->name('level.destroy');
        Route::get('/level/import', [LevelController::class, 'import'])->name('level.import');
        Route::post('/level/import_ajax', [LevelController::class, 'import_ajax'])->name('level.import_ajax');
        Route::get('/level/export_excel', [LevelController::class, 'export_excel'])->name('level.export_excel');
        Route::get('/level/export_pdf', [LevelController::class, 'export_pdf'])->name('level.export_pdf');

        // Ajax Routes
        Route::get('/list', [LevelController::class, 'list'])->name('level.list');
    });

    // Kategori Routes
    Route::prefix('kategori')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
        Route::get('/list', [KategoriController::class, 'list'])->name('kategori.list');
        Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/{id}', [KategoriController::class, 'show'])->name('kategori.show');
        Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
        Route::get('/import', [KategoriController::class, 'import'])->name('kategori.import');
        Route::post('/import_ajax', [KategoriController::class, 'import_ajax'])->name('kategori.import_ajax');
        Route::get('/export_excel', [KategoriController::class, 'export_excel'])->name('kategori.export_excel');
        Route::get('/export_pdf', [KategoriController::class, 'export_pdf'])->name('kategori.export_pdf');
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
        Route::get('/{id}', [StokController::class, 'show'])->name('stok.show');

        // Ajax Routes
        Route::get('/create-ajax', [StokController::class, 'create'])->name('stok.create_ajax');
        Route::get('/{id}/edit-ajax', [StokController::class, 'edit'])->name('stok.edit_ajax');
    });

    // Barang Routes
    // Route::middleware(['authorize:ADM, MNG'])->group(function () {
        Route::prefix('barang')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('barang.index');
        Route::get('/list', [BarangController::class, 'list'])->name('barang.list');
        Route::get('/create', [BarangController::class, 'create'])->name('barang.create');
        Route::post('/', [BarangController::class, 'store'])->name('barang.store');
        Route::get('/{id}', [BarangController::class, 'show'])->name('barang.show');
        Route::get('/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
        Route::put('/{id}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
Route::get('/import', [BarangController::class, 'import']); // ajax form upload excel
Route::post('/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
Route::get('/export_excel', [BarangController::class, 'export_excel']); // export excel
Route::get('/export_pdf', [BarangController::class, 'export_pdf']); // export pdf
    });

    // Supplier Routes
    Route::prefix('supplier')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('/create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('/', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::put('/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
        Route::get('/supplier/import', [SupplierController::class, 'import'])->name('supplier.import');
Route::post('/supplier/import_ajax', [SupplierController::class, 'import_ajax'])->name('supplier.import_ajax');
Route::get('/supplier/export_excel', [SupplierController::class, 'export_excel'])->name('supplier.export_excel');
Route::get('/supplier/export_pdf', [SupplierController::class, 'export_pdf'])->name('supplier.export_pdf');
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('/profile/upload', [ProfileController::class, 'upload'])->name('profile.upload');

   
// });