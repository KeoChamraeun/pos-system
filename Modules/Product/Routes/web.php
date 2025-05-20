<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\CategoriesController;
use Modules\Product\Http\Controllers\BarcodeController;

Route::middleware(['auth'])->group(function () {
    // Print Barcode
    Route::get('/products/print-barcode', [BarcodeController::class, 'printBarcode'])->name('barcode.print');

    // Product
    Route::resource('products', ProductController::class);

    // Product Category
    Route::resource('product-categories', CategoriesController::class)->except(['create', 'show']);
});
