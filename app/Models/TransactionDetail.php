<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price',
    ];

    // --- LOGIKA OTOMATIS POTONG STOK ---
    protected static function booted(): void
    {
        // Jalankan saat detail transaksi DIBUAT
        static::created(function (TransactionDetail $detail) {
            // Cari produknya, lalu kurangi stok (nama kolom 'stock' sesuaikan dengan database kamu)
            $detail->product()->decrement('stock', $detail->quantity);
        });

        // (Opsional) Jalankan saat transaksi DIHAPUS (Stok balik lagi)
        static::deleted(function (TransactionDetail $detail) {
             $detail->product()->increment('stock', $detail->quantity);
        });
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}