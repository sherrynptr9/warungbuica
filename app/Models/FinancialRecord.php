<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'amount',
        'type', // income atau expense
        'description',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    // --- RELASI ---

    // Laporan dicatat oleh satu User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}