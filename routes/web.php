<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tentang', function () {
    return view('tentang');
});

Route::get('/sapa/{nama}', function ($nama) {
    // ↑ '/sapa/{nama}' = URL pattern
    // ↑ {nama}         = Parameter dinamis, nilainya dari URL
    // ↑ function($nama) = Parameter diterima di function

    return "Halo, $nama! Selamat datang di Toko Online.";
    // ↑ "$nama" = Variable interpolation (masukkan nilai $nama ke string)
});

Route::get('/kategori/{nama?}', function ($nama = 'Semua') {
    // ↑ {nama?} = Tanda ? berarti parameter OPSIONAL
    // ↑ $nama = 'Semua' = Nilai default jika parameter tidak diberikan

    return "Menampilkan kategori: $nama";
});

Route::get('/produk/{id}', function ($id) {
    return "Detail produk #$id";
})->name('produk.detail');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    // Semua route di dalam group ini HARUS LOGIN

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');
    // ↑ ->name('home') = Memberi nama route
    // Kegunaan: route('home') akan menghasilkan URL /home

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});
