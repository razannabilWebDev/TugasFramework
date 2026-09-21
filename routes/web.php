<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])
  ->name('dashboard');

Route::get('/about', function () {
    return '<h2>Profil Toko</h2>
            <p>Selamat datang di sistem POS kami. Kami berkomitmen menyediakan layanan transaksi yang cepat, akurat, dan terpercaya untuk mendukung bisnis Anda.</p>';
});


Route::get('/login', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('login');
 
Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest')
    ->name('login.store');
 
Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('report.sales');
});
 
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos', [PosController::class, 'store'])->name('pos.store');
    Route::post('/pos', [PosController::class, 'history'])->name('pos.history');
});

Route::get('/index', function () {
    $posts = [
        ['title' => 'Post 1', 'content' => 'Belajar Blade 1'],
        ['title' => 'Post 2', 'content' => 'Belajar Blade 2'],
        ['title' => 'Post 3', 'content' => 'Belajar Blade 3'],
    ];
    return view('posts.index');
})->middleware(['auth', 'role:admin,kasir'])
  ->name('index');
