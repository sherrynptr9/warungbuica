<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman katalog produk.
     */
    

    public function index(Request $request)
{
    $products = Product::query();

    if ($request->search) {
        $products->where('name', 'like', "%{$request->search}%");
    }

    if ($request->category) {
        $products->where('category', $request->category);
    }

    $products = $products->paginate(12); // ← WAJIB pakai paginate, bukan get()

    return view('products.index', compact('products'));
}

}