<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/katalog', function () {
    $products = Product::all();
    // Ambil daftar kategori unik dari tabel produk
    $categories = Product::select('category')->distinct()->whereNotNull('category')->pluck('category');

    return view('katalog_produk', compact('products', 'categories'));
});
