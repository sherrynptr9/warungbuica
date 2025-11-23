<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Siapa yang boleh melihat menu 'Kelola User' di sidebar?
     * HANYA ADMIN.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Siapa yang boleh melihat detail user lain?
     * HANYA ADMIN.
     */
    public function view(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Siapa yang boleh membuat user baru?
     * HANYA ADMIN.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Siapa yang boleh MENGEDIT user?
     * HANYA ADMIN.
     */
    public function update(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Siapa yang boleh menghapus user?
     * HANYA ADMIN.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }
}