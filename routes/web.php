<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;

Route::view('/', 'dashboard')->name('dashboard.index');
Route::resource('/invoice', InvoiceController::class);
Route::get('/invoice/{num}/print', [InvoiceController::class, 'print'])->name('invoice.print');