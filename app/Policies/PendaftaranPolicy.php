<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Pendaftaran;
use Illuminate\Auth\Access\HandlesAuthorization;

class PendaftaranPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->hasRole(['admin', 'super_admin']);
    }

    public function view(AuthUser $authUser, Pendaftaran $pendaftaran): bool
    {
        return $authUser->hasRole(['admin', 'super_admin']);
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->hasRole(['admin', 'super_admin']);
    }

    public function update(AuthUser $authUser, Pendaftaran $pendaftaran): bool
    {
        return $authUser->hasRole(['admin', 'super_admin']);
    }

    public function delete(AuthUser $authUser, Pendaftaran $pendaftaran): bool
    {
        return $authUser->hasRole(['admin', 'super_admin']);
    }

    public function restore(AuthUser $authUser, Pendaftaran $pendaftaran): bool
    {
        return $authUser->hasRole(['admin', 'super_admin']);
    }

    public function forceDelete(AuthUser $authUser, Pendaftaran $pendaftaran): bool
    {
        return $authUser->hasRole(['admin', 'super_admin']);
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->hasRole(['admin', 'super_admin']);
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->hasRole(['admin', 'super_admin']);
    }

    public function replicate(AuthUser $authUser, Pendaftaran $pendaftaran): bool
    {
        return $authUser->hasRole(['admin', 'super_admin']);
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->hasRole(['admin', 'super_admin']);
    }
}
