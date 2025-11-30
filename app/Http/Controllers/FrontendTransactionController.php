<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
// use App\Models\FinancialRecord; // Tidak perlu di-import lagi karena sudah otomatis di Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class FrontendTransactionController extends Controller
{
    // 💰 Tampilan Keranjang
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // 🛒 Tambah Ke Keranjang
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // 🗑 Hapus Barang dari Keranjang
    public function removeItem($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    // 🧾 PROSES CHECKOUT
    public function checkout(Request $request)
    {
        $cart = Session::get('cart', []);

        // Cek apakah keranjang kosong
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang masih kosong.');
        }

        // Mulai Database Transaction (Agar data konsisten)
        DB::beginTransaction();

        try {
            // 1. Hitung Total Harga
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // 2. Simpan Data Transaksi (Tabel Transactions)
            // ⚠️ PENTING: Saat baris ini jalan, Model Transaction akan OTOMATIS membuat FinancialRecord
            // Pastikan kamu sudah menambahkan method 'booted()' di App\Models\Transaction.php
            $transaction = Transaction::create([
                'user_id' => Auth::id(),                
                'total_amount' => $total,
                'payment_status' => 'paid',             
            ]);

            // 3. Simpan Detail Barang (Tabel Transaction_Details)
            foreach ($cart as $productId => $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // ✅ FinancialRecord TIDAK DIBUAT DISINI LAGI (Sudah otomatis via Model)

            // Jika semua berhasil, simpan permanen ke database
            DB::commit();

            // Kosongkan Keranjang
            Session::forget('cart');

            return redirect()->route('cart.index')->with('success', 'Transaksi berhasil diproses!');

        } catch (\Exception $e) {
            // Jika ada error, batalkan semua perubahan database
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}