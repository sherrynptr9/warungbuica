<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::created(function (Transaction $transaction) {
            FinancialRecord::create([
                'date' => $transaction->created_at,
                'amount' => $transaction->total_amount,
                'type' => 'income',
                'description' => 'Pendapatan Transaksi #' . $transaction->id,
                'user_id' => $transaction->user_id,
            ]);
        });
    }

    // Transaksi milik satu User (Kasir)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Transaksi punya banyak Detail Barang
    // Nama fungsi 'details' ini penting karena dipanggil di Resource
    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }


}