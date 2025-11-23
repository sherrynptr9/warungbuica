<?php

namespace App\Policies;

use App\Models\FinancialRecord;
use App\Models\User;

class FinancialRecordPolicy
{
    /**
     * Siapa yang boleh melihat daftar laporan di sidebar?
     * HANYA ADMIN.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Siapa yang boleh melihat detail satu laporan?
     * HANYA ADMIN.
     */
    public function view(User $user, FinancialRecord $financialRecord): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Siapa yang boleh mencatat laporan baru?
     * HANYA ADMIN.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Siapa yang boleh mengedit laporan?
     * HANYA ADMIN.
     */
    public function update(User $user, FinancialRecord $financialRecord): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Siapa yang boleh menghapus laporan?
     * HANYA ADMIN.
     */
    public function delete(User $user, FinancialRecord $financialRecord): bool
    {
        return $user->role === 'admin';
    }
}