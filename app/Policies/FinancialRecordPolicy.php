<?php

namespace App\Policies;

use App\Models\FinancialRecord;
use App\Models\User;

class FinancialRecordPolicy
{
    /**
     * Siapa yang boleh melihat menu Laporan Keuangan di sidebar?
     * return true = SEMUA ROLE (Admin & Kasir) boleh.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Siapa yang boleh melihat detail laporan?
     * return true = SEMUA ROLE boleh.
     */
    public function view(User $user, FinancialRecord $financialRecord): bool
    {
        return true;
    }

    /**
     * Siapa yang boleh menambah laporan baru?
     * return true = SEMUA ROLE boleh.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Siapa yang boleh MENGEDIT laporan?
     * return false = TIDAK ADA yang boleh (Data aman/dikunci).
     */
    public function update(User $user, FinancialRecord $financialRecord): bool
    {
        return false;
    }

    /**
     * Siapa yang boleh MENGHAPUS laporan?
     * return false = TIDAK ADA yang boleh.
     */
    public function delete(User $user, FinancialRecord $financialRecord): bool
    {
        return false;
    }
}