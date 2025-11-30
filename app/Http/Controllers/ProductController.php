<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman katalog produk.
     */
    public function index()
    {
        // Ambil semua produk, urutkan dari yang terbaru
        $products = Product::latest()->get();

        // Kirim data produk ke view 'products.index'
        return view('products.index', compact('products'));
    }
}