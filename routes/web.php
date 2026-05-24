<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| 1. Halaman Publik (Bisa Diakses Semua Orang Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home'); // Mengembalikan ke halaman utama AgroMonitor kamu
});

Route::get('/about', function () {
    return view('about');
});

// Halaman untuk menampilkan form kontak
Route::get('/contact', function () {
    return view('contact');
});

// Memproses pengiriman email dari form kontak
Route::post('/contact', [ContactController::class, 'sendEmail'])->name('contact.send');

// Hortikultura bisa diakses tanpa login
Route::get('/hortikultura', function () {
    return view('hortikultura');
})->name('hortikultura');


/*
|--------------------------------------------------------------------------
| 2. Halaman Khusus Penyewa & Admin (Wajib Login & Cek Peran/Role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkRole:tenant,admin'])->group(function () {
    // Halaman Utama Monitoring IoT kamu (Hanya User 1 / Tenant & Admin)
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');
    Route::get('/dashboard', [MonitoringController::class, 'index'])->name('dashboard');
    
    // Route untuk mengunduh laporan PDF riwayat sensor (Mendukung Filter)
    Route::get('/monitoring/pdf', [MonitoringController::class, 'downloadPdf'])->name('monitoring.pdf');
});


/*
|--------------------------------------------------------------------------
| 3. Halaman Terproteksi Umum (Wajib Login Saja, Semua Role Bisa Akses)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Fitur Edit Profil bawaan Laravel Breeze (Bisa diakses oleh tenant, guest, maupun admin)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| 4. Halaman Khusus Admin (Hanya Bisa Diakses Akun Ber-Role Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkRole:admin'])->group(function () {
    // Halaman melihat seluruh daftar user & statusnya
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    
    // Tombol aksi untuk mengubah status peran user secara instan
    Route::patch('/admin/users/{id}/make-tenant', [AdminUserController::class, 'makeTenant'])->name('admin.users.make-tenant');
    Route::patch('/admin/users/{id}/make-guest', [AdminUserController::class, 'makeGuest'])->name('admin.users.make-guest');
});


/*
|--------------------------------------------------------------------------
| 5. File Otentikasi Bawaan Laravel Breeze (Login, Register, dll)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';