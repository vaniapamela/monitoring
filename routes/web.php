<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| 1. Halaman Publik (Bebas Akses)
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('home'));
Route::get('/about', fn() => view('about'));
Route::get('/contact', fn() => view('contact'));
Route::get('/hortikultura', fn() => view('hortikultura'))->name('hortikultura');

/*
|--------------------------------------------------------------------------
| 2. Dashboard (Pembagi Arah)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.users.index');
    }
    return redirect()->route('monitoring');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| 3. Monitoring (Bisa diakses semua user login)
| Logika "Kosong" atau "Realtime" diatur di MonitoringController
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');
    Route::get('/monitoring/pdf', [MonitoringController::class, 'downloadPdf'])->name('monitoring.pdf');
});

/*
|--------------------------------------------------------------------------
| 4. Profil (Semua login bisa akses)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| 5. Halaman Khusus Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', CheckRole::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::post('/users/{id}/toggle', [AdminUserController::class, 'toggleStatus'])->name('users.toggle');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';