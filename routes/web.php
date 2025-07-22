<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/pemakaian/{pemakaian}/pdf', [\App\Http\Controllers\PemakaianPdfController::class, 'download'])->name('pemakaian.pdf');

Route::get('/stok/pdf', [\App\Http\Controllers\StokPdfController::class, 'download'])->name('stok.pdf');

Route::get('/rekapusulan/pdf', [\App\Http\Controllers\RekapUsulanPdfController::class, 'download'])->name('rekapusulan.pdf');
