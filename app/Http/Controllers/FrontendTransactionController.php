<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\FinancialRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FrontendTransactionController extends Controller
{
    // Tampilkan Halaman Keranjang
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Tambah Barang ke Keranjang
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = Session::get('cart', []);

        // Cek stok sebelum menambah
        $currentQty = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        
        if ($product->stock <= $currentQty) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        // Jika barang sudah ada, tambah jumlahnya
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Jika belum, masukkan data baru
            $cart[$id] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'photo' => null // Bisa ditambahkan jika ada foto
            ];
        }

        Session::put('cart', $cart);
        // Kita gunakan redirect()->back() tanpa pesan sukses agar user bisa klik + berkali-kali dengan cepat tanpa terganggu flash message
        return redirect()->back()->with('success', 'Barang berhasil ditambahkan ke keranjang!'); 
    }

    // --- FUNGSI BARU: KURANGI KUANTITAS ---
    public function decreaseQuantity($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                // Jika jumlah > 1, kurangi 1
                $cart[$id]['quantity']--;
                Session::put('cart', $cart);
            } else {
                // Jika jumlah tinggal 1, hapus barangnya dari keranjang
                unset($cart[$id]);
                Session::put('cart', $cart);
            }
        }
        return redirect()->back();
    }

    // Hapus Barang dari Keranjang (Tombol Sampah)
    public function removeFromCart($id)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Barang dihapus dari keranjang.');
    }

    // Proses Checkout (Simpan ke Database)
    public function checkout()
    {
        $cart = Session::get('cart');

        if (!$cart) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            foreach ($cart as $details) {
                $totalAmount += $details['price'] * $details['quantity'];
            }

            // 1. Buat Transaksi Header
            $transaction = Transaction::create([
                // Karena ini frontend publik, kita pakai User ID 1 (Admin) atau user yg login sebagai default
                'user_id' => auth()->id() ?? 1, 
                'total_amount' => $totalAmount,
                'payment_status' => 'paid', // Asumsi langsung bayar tunai
            ]);

            // 2. Buat Detail & Potong Stok
            foreach ($cart as $id => $details) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);

                // Kurangi Stok
                $product = Product::find($id);
                if ($product) {
                    $product->decrement('stock', $details['quantity']);
                }
            }

            // 3. Catat Laporan Keuangan
            FinancialRecord::create([
                'date' => now(),
                'type' => 'income',
                'amount' => $totalAmount,
                'description' => 'Penjualan Frontend #' . $transaction->id,
                'user_id' => auth()->id() ?? 1,
            ]);

            DB::commit();
            Session::forget('cart'); // Kosongkan keranjang

            return redirect()->route('home')->with('success', 'Transaksi Berhasil! Terima kasih.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}