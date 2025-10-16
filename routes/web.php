<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerController;

Route::view('/', 'dashboard')->name('dashboard.index');
Route::resource('/invoice', InvoiceController::class);
Route::get('/invoice/{num}/createpdf', [InvoiceController::class, 'createPdf'])->name('invoice.createpdf');
Route::resource('/customer', CustomerController::class);
Route::get('/api/customer/search', [CustomerController::class, 'fetch'])->name('customer.search');
Route::get('/invoice/{num}/preview', [InvoiceController::class, 'preview'])->name('invoice.preview');
Route::get('/invoice/{num}/download', [InvoiceController::class, 'download'])->name('invoice.download');
Route::post('/invoices/{num}/upload/stamp', [InvoiceController::class, 'stamp'])->name('invoices.stamp');
Route::post('/invoices/{num}/upload/final', [InvoiceController::class, 'final'])->name('invoices.final');
