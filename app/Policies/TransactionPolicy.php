<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    /**
     * Siapa yang boleh melihat daftar transaksi?
     * SEMUA (Admin & Kasir) boleh.
     */
    public function viewAny(User $user): bool
    {
        return true; 
    }

    /**
     * Siapa yang boleh melihat detail 1 transaksi?
     * SEMUA boleh.
     */
    public function view(User $user, Transaction $transaction): bool
    {
        return true;
    }

    /**
     * Siapa yang boleh MEMBUAT transaksi baru?
     * SEMUA boleh (Kasir butuh ini untuk jualan).
     */
    public function create(User $user): bool
    {
        return true; 
    }

    /**
     * Siapa yang boleh MENGEDIT transaksi yang sudah ada?
     * HANYA ADMIN.
     * Tombol Edit akan hilang otomatis untuk Kasir.
     */
    public function update(User $user, Transaction $transaction): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Siapa yang boleh MENGHAPUS transaksi?
     * HANYA ADMIN.
     * Tombol Delete akan hilang otomatis untuk Kasir.
     */
    public function delete(User $user, Transaction $transaction): bool
    {
        return $user->role === 'admin';
    }
}