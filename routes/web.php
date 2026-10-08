<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ProfileSetupController;

// --- PUBLIC ROUTES ---
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/kas/download-pdf', [KasController::class, 'exportPDF'])->name('kas.pdf');
Route::get('/setup-profile', [ProfileSetupController::class, 'index'])->name('setup.profile')->middleware('auth');
Route::post('/setup-profile', [ProfileSetupController::class, 'store'])->name('save.profile')->middleware('auth');

// --- AUTH ROUTES (Harus Login) ---
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- MANAJEMEN KAS (Pemasukan) ---
    // Menampilkan data & Form Tambah
    Route::get('/kas', [KasController::class, 'index'])->name('kas.index');
    Route::post('/kas', [KasController::class, 'store'])->name('kas.store');

    // Edit & Update (Menggunakan parameter {id})
    Route::get('/kas/{id}/edit', [KasController::class, 'edit'])->name('kas.edit');
    Route::put('/kas/{id}', [KasController::class, 'update'])->name('kas.update');
    
    // Hapus (Menggunakan method DELETE)
    Route::delete('/kas/{id}', [KasController::class, 'destroy'])->name('kas.destroy');

    // --- MANAJEMEN SISWA ---
    // Menggunakan Resource: otomatis menangani index, store, edit, update, destroy
    Route::resource('siswa', SiswaController::class);

    // --- MANAJEMEN PENGELUARAN ---
    Route::resource('pengeluaran', PengeluaranController::class);
});