<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[0-9]+'); //artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
// New routes for registration
Route::get('register', [AuthController::class, 'postregister'])->name('register'); 
Route::post('register', [AuthController::class, 'register']); 

Route::middleware(['auth'])->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);

    Route::group(['prefix'=>'level','middleware'=>['authorize:ADM']], function () {
        Route::get('/', [LevelController::class, 'index']);          // menampilkan halaman awal level
        Route::post('/list', [LevelController::class, 'list']);      // menampilkan data level dalam json untuk datables
        Route::get('/create', [LevelController::class, 'create']);   // menampilkan halaman form tambah level
        Route::post('/', [LevelController::class, 'store']);          // menyimpan data level baru
        Route::get('/create_ajax', [LevelController::class, 'create_ajax']); // Menampilkan halaman form tambah level Ajax
        Route::post('/ajax', [LevelController::class, 'store_ajax']); // Menampilkan data level baru Ajax
        Route::get('/{id}', [LevelController::class, 'show']);       // menampilkan detail level
        Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);
        Route::get('/{id}/edit', [LevelController::class, 'edit']);  // menampilkan halaman form edit level
        Route::put('/{id}', [LevelController::class, 'update']);     // menyimpan perubahan data level
        Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // Menampilkan halaman form edit level Ajax
        Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); // Menyimpan perubahan data level Ajax
        Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete level Ajax
        Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Untuk hapus data level Ajax
        Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data level
        Route::get('/import', [LevelController::class, 'import']); // ajax form upload excel
        Route::post('/import_ajax', [LevelController::class, 'import_ajax']); // ajax import excel
        Route::get('/export_excel', [LevelController::class, 'export_excel']); // export excel
    });

    Route::group(['prefix' => 'user','middleware'=>['authorize:ADM']], function () {
        Route::get('/', [UserController::class, 'index']);          // menampilkan halaman awal user
        Route::post('/list', [UserController::class, 'list']);      // menampilkan data user dalam json untuk datables
        Route::get('/create', [UserController::class, 'create']);   // menampilkan halaman form tambah user
        Route::post('/', [UserController::class, 'store']);          // menyimpan data user baru
        Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
        Route::post('/ajax', [UserController::class, 'store_ajax']); // Menampilkan data user baru Ajax
        Route::get('/{id}', [UserController::class, 'show']);       // menampilkan detail user
        Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);
        Route::get('/{id}/edit', [UserController::class, 'edit']);  // menampilkan halaman form edit user
        Route::put('/{id}', [UserController::class, 'update']);     // menyimpan perubahan data user
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // Menampilkan halaman form edit user Ajax
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
        Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
        Route::get('/import', [UserController::class, 'import']); // ajax form upload excel
        Route::post('/import_ajax', [UserController::class, 'import_ajax']); // ajax import excel
        Route::get('/export_excel', [UserController::class, 'export_excel']); // export excel
    });

    Route::group(['prefix' => 'kategori','middleware'=>['authorize:ADM,MNG,STF']], function () {
        Route::get('/', [KategoriController::class, 'index']);          // menampilkan halaman awal kategori
        Route::post('/list', [KategoriController::class, 'list']);      // menampilkan data kategori dalam json untuk datables
        Route::get('/create', [KategoriController::class, 'create']);   // menampilkan halaman form tambah kategori
        Route::post('/', [KategoriController::class, 'store']);          // menyimpan data kategori baru
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); // Menampilkan halaman form tambah kategori Ajax
        Route::post('/ajax', [KategoriController::class, 'store_ajax']); // Menampilkan data kategori baru Ajax
        Route::get('/{id}', [KategoriController::class, 'show']);       // menampilkan detail kategori
        Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);
        Route::get('/{id}/edit', [KategoriController::class, 'edit']);  // menampilkan halaman form edit kategori
        Route::put('/{id}', [KategoriController::class, 'update']);     // menyimpan perubahan data kategori
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // Menampilkan halaman form edit kategori Ajax
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // Menyimpan perubahan data kategori Ajax
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete kategori Ajax
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // Untuk hapus data kategori Ajax
        Route::delete('/{id}', [KategoriController::class, 'destroy']); // menghapus data kategori
        Route::get('/import', [KategoriController::class, 'import']); // ajax form upload excel
        Route::post('/import_ajax', [KategoriController::class, 'import_ajax']); // ajax import excel
        Route::get('/export_excel', [KategoriController::class, 'export_excel']); // export excel
    });

    Route::group(['prefix' => 'supplier','middleware'=>['authorize:ADM,MNG,STF']], function () {
        Route::get('/', [SupplierController::class, 'index']);          // menampilkan halaman awal supplier
        Route::post('/list', [SupplierController::class, 'list']);      // menampilkan data supplier dalam json untuk datables
        Route::get('/create', [SupplierController::class, 'create']);   // menampilkan halaman form tambah supplier
        Route::post('/', [SupplierController::class, 'store']);          // menyimpan data supplier baru
        Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // Menampilkan halaman form tambah supplier Ajax
        Route::post('/ajax', [SupplierController::class, 'store_ajax']); // Menampilkan data supplier baru Ajax
        Route::get('/{id}', [SupplierController::class, 'show']);       // menampilkan detail supplier
        Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']);
        Route::get('/{id}/edit', [SupplierController::class, 'edit']);  // menampilkan halaman form edit supplier
        Route::put('/{id}', [SupplierController::class, 'update']);     // menyimpan perubahan data supplier
        Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // Menampilkan halaman form edit supplier Ajax
        Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // Menyimpan perubahan data supplier Ajax
        Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete supplier Ajax
        Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Untuk hapus data supplier Ajax
        Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data supplier
        Route::get('/import', [SupplierController::class, 'import']); // ajax form upload excel
        Route::post('/import_ajax', [SupplierController::class, 'import_ajax']); // ajax import excel
        Route::get('/export_excel', [SupplierController::class, 'export_excel']); // export excel
    });

    Route::group(['prefix' => 'barang','middleware'=>['authorize:ADM,MNG,STF']], function () {
        Route::get('/', [BarangController::class, 'index']);          // menampilkan halaman awal barang
        Route::post('/list', [BarangController::class, 'list']);      // menampilkan data barang dalam json untuk datables
        Route::get('/create', [BarangController::class, 'create']);   // menampilkan halaman form tambah barang
        Route::post('/', [BarangController::class, 'store']);          // menyimpan data barang baru
        Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // Menampilkan halaman form tambah barang Ajax
        Route::post('/ajax', [BarangController::class, 'store_ajax']); // Menampilkan data barang baru Ajax
        Route::get('/{id}', [BarangController::class, 'show']);       // menampilkan detail barang
        Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);
        Route::get('/{id}/edit', [BarangController::class, 'edit']);  // menampilkan halaman form edit barang
        Route::put('/{id}', [BarangController::class, 'update']);     // menyimpan perubahan data barang
        Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // Menampilkan halaman form edit barang Ajax
        Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // Menyimpan perubahan data barang Ajax
        Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete barang Ajax
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data barang Ajax
        Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data barang
        Route::get('/import', [BarangController::class, 'import']); // ajax form upload excel
        Route::post('/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
        Route::get('/export_excel', [BarangController::class, 'export_excel']); // export excel
        Route::get('/export_pdf', [BarangController::class, 'export_pdf']); // export pdf
    });
});
