<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('IsLogout')->group(function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');
    Route::post('/login', [UserController::class, 'loginProses'])->name('login.proses');
});


// Route::httpMethod('/path', [NamaController::class, 'namaFunc'])->name('identitas_route');
// httpMethod
// get -> mengambil data/menampilkan halaman
// post -> mengirim data ke database (tambah data)
// patch/put -> mengubah data di database
// delete -> menghapus data
Route::middleware('IsLogin')->group(function () {
    Route::get('/logout', [UserController::class, 'logoutProses'])->name('logout.proses');
    Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing_page');

    Route::middleware('IsAdmin')->group(function () {
        // mengelola data hewan
        Route::prefix('/data-hewan')->name('data_hewan.')->group(function () {
            Route::get('/', [PetController::class, 'index'])->name('data');
            Route::get('/tambah', [PetController::class, 'create'])->name('tambah');
            Route::post('/tambah/proses', [PetController::class, 'store'])->name('tambah.proses');
            Route::get('/ubah/{id}', [PetController::class, 'edit'])->name('ubah');
            Route::patch('/ubah/{id}/proses', [PetController::class, 'update'])->name('ubah.proses');
            Route::delete('/hapus/{id}', [PetController::class, 'destroy'])->name('hapus');
            Route::patch('/ubah/stok/{id}', [PetController::class, 'updateStock'])->name('ubah.stok');
        });

        Route::prefix('/data-user')->name('data_user.')->group(function () {
            Route::get('/data', [UserController::class, 'index'])->name('data');
            Route::get('/tambah', [UserController::class, 'create'])->name('tambah');
            Route::post('/tambah/proses', [UserController::class, 'store'])->name('tambah.proses');
            Route::get('/ubah/{id}', [UserController::class, 'edit'])->name('ubah');
            Route::patch('/ubah/{id}/proses', [UserController::class, 'update'])->name('ubah.proses');
            Route::delete('/hapus/{id}', [UserController::class, 'destroy'])->name('hapus');
        });

        Route::prefix('/admin')->name('admin.')->group(function () {
            Route::prefix('/order')->name('order.')->group(function () {
                Route::get('/', [OrderController::class, 'index'])->name('index');
                Route::get('/export-excel', [OrderController::class, 'exportExcel'])->name('export');
            });
        });
    });

    Route::middleware('IsKasir')->group(function () {
        Route::prefix('/kasir')->name('kasir.')->group(function () {
            Route::prefix('/order')->name('order.')->group(function () {
                Route::get('/', [OrderController::class, 'index'])->name('index');
                Route::get('/create', [OrderController::class, 'create'])->name('create');
                Route::post('/create/process', [OrderController::class, 'store'])->name('store');
                Route::get('/print/{id}', [OrderController::class, 'show'])->name('print');
                Route::get('/download/{id}', [OrderController::class, 'downloadPDF'])->name('download');
            });
        });
    });
});