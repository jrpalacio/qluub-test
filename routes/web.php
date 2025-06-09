<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Models\Product;

Route::get('/', function () {
    $products = Product::all();
    return Inertia::render('Welcome', [
        'products' => $products,
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('products', ProductController::class)->middleware(['auth', 'verified', 'admin']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
