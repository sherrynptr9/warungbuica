<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

// --- IMPORT SEMUA MODEL & POLICY ---
use App\Models\User;
use App\Policies\UserPolicy;
use App\Models\FinancialRecord;
use App\Policies\FinancialRecordPolicy;
use App\Models\Transaction;
use App\Policies\TransactionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Daftar semua aturan hak akses (Policy).
     */
    protected $policies = [
        // Aturan untuk User (Hanya Admin yang bisa kelola user)
        User::class => UserPolicy::class,

        // Aturan untuk Laporan Keuangan (Hanya Admin)
        FinancialRecord::class => FinancialRecordPolicy::class,

        // Aturan untuk Transaksi (Kasir gaboleh edit/hapus)
        Transaction::class => TransactionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}