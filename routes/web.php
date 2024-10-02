<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'level'], function() {
    Route::get('/', [LevelController::class, 'index']);          // menampilkan halaman awal user
    Route::post('/list', [LevelController::class, 'list']);      // menampilkan data user dalam json untuk datables
    Route::get('/create', [LevelController::class, 'create']);   // menampilkan halaman form tambah user
    Route::post('/', [LevelController::class,'store']);          // menyimpan data user baru
    Route::get('/{id}', [LevelController::class, 'show']);       // menampilkan detail user
    Route::get('/{id}/edit', [LevelController::class, 'edit']);  // menampilkan halaman form edit user
    Route::put('/{id}', [LevelController::class, 'update']);     // menyimpan perubahan data user
    Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data user
});

Route::group(['prefix' => 'user'], function() {
    Route::get('/', [UserController::class, 'index']);          // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);      // menampilkan data user dalam json untuk datables
    Route::get('/create', [UserController::class, 'create']);   // menampilkan halaman form tambah user
    Route::post('/', [UserController::class,'store']);          // menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']); // Menampilkan data user baru Ajax
    Route::get('/{id}', [UserController::class, 'show']);       // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);  // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);     // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // Menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax
    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});

Route::group(['prefix' => 'kategori'], function() {
    Route::get('/', [KategoriController::class, 'index']);          // menampilkan halaman awal user
    Route::post('/list', [KategoriController::class, 'list']);      // menampilkan data user dalam json untuk datables
    Route::get('/create', [KategoriController::class, 'create']);   // menampilkan halaman form tambah user
    Route::post('/', [KategoriController::class,'store']);          // menyimpan data user baru
    Route::get('/{id}', [KategoriController::class, 'show']);       // menampilkan detail user
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);  // menampilkan halaman form edit user
    Route::put('/{id}', [KategoriController::class, 'update']);     // menyimpan perubahan data user
    Route::delete('/{id}', [KategoriController::class, 'destroy']); // menghapus data user
});

Route::group(['prefix' => 'supplier'], function() {
    Route::get('/', [SupplierController::class, 'index']);          // menampilkan halaman awal user
    Route::post('/list', [SupplierController::class, 'list']);      // menampilkan data user dalam json untuk datables
    Route::get('/create', [SupplierController::class, 'create']);   // menampilkan halaman form tambah user
    Route::post('/', [SupplierController::class,'store']);          // menyimpan data user baru
    Route::get('/{id}', [SupplierController::class, 'show']);       // menampilkan detail user
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);  // menampilkan halaman form edit user
    Route::put('/{id}', [SupplierController::class, 'update']);     // menyimpan perubahan data user
    Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data user
});

Route::group(['prefix' => 'barang'], function() {
    Route::get('/', [BarangController::class, 'index']);          // menampilkan halaman awal user
    Route::post('/list', [BarangController::class, 'list']);      // menampilkan data user dalam json untuk datables
    Route::get('/create', [BarangController::class, 'create']);   // menampilkan halaman form tambah user
    Route::post('/', [BarangController::class,'store']);          // menyimpan data user baru
    Route::get('/{id}', [BarangController::class, 'show']);       // menampilkan detail user
    Route::get('/{id}/edit', [BarangController::class, 'edit']);  // menampilkan halaman form edit user
    Route::put('/{id}', [BarangController::class, 'update']);     // menyimpan perubahan data user
    Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data user
});