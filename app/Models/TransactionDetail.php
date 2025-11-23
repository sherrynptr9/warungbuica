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

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // --- RELASI ---

    // Detail ini milik satu Transaksi (Header)
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    // Detail ini merujuk ke satu Produk
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}