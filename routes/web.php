<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerController;

Route::view('/', 'dashboard')->name('dashboard.index');
Route::resource('/invoice', InvoiceController::class);
Route::get('/invoice/{num}/print', [InvoiceController::class, 'print'])->name('invoice.print');
Route::resource('/customer', CustomerController::class);
Route::get('/api/customer/search', [CustomerController::class, 'fetch'])->name('customer.search');