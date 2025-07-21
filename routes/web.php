<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/pemakaian/{pemakaian}/pdf', [\App\Http\Controllers\PemakaianPdfController::class, 'download'])->name('pemakaian.pdf');
