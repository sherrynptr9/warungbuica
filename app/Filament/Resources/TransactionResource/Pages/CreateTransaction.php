<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\FinancialRecord; // Import Model Keuangan
use App\Models\Product;         // Import Model Barang
use Illuminate\Support\Facades\DB;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    /**
     * Fungsi ini otomatis dijalankan SETELAH data transaksi berhasil disimpan.
     */
    protected function afterCreate(): void
    {
        // Ambil data transaksi yang baru saja dibuat
        $transaction = $this->record;

        // Cek apakah status pembayarannya 'paid' (Lunas)
        if ($transaction->payment_status === 'paid') {
            
            // --- 1. LOGIKA POTONG STOK ---
            // Loop setiap barang yang dibeli di transaksi ini
            foreach ($transaction->details as $detail) {
                $product = Product::find($detail->product_id);
                
                if ($product) {
                    // Kurangi stok barang sesuai jumlah beli
                    $product->decrement('stock', $detail->quantity);
                }
            }

            // --- 2. LOGIKA LAPORAN KEUANGAN ---
            // Buat catatan otomatis di tabel financial_records
            FinancialRecord::create([
                'date'        => now(), // Tanggal hari ini
                'type'        => 'income', // Tipe: Pemasukan
                'amount'      => $transaction->total_amount, // Ambil total dari transaksi
                'description' => "Penjualan Transaksi #" . $transaction->id . " oleh " . auth()->user()->name,
                'user_id'     => auth()->id(), // ID Kasir yang sedang login
            ]);
        }
    }

    /**
     * Opsional: Agar setelah create langsung diarahkan ke list (daftar) lagi,
     * tidak diam di form create.
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}