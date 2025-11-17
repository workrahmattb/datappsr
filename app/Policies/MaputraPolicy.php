<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Maputra;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaputraPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Maputra');
    }

    public function view(AuthUser $authUser, Maputra $maputra): bool
    {
        return $authUser->can('View:Maputra');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Maputra');
    }

    public function update(AuthUser $authUser, Maputra $maputra): bool
    {
        return $authUser->can('Update:Maputra');
    }

    public function delete(AuthUser $authUser, Maputra $maputra): bool
    {
        return $authUser->can('Delete:Maputra');
    }

    public function restore(AuthUser $authUser, Maputra $maputra): bool
    {
        return $authUser->can('Restore:Maputra');
    }

    public function forceDelete(AuthUser $authUser, Maputra $maputra): bool
    {
        return $authUser->can('ForceDelete:Maputra');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Maputra');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Maputra');
    }

    public function replicate(AuthUser $authUser, Maputra $maputra): bool
    {
        return $authUser->can('Replicate:Maputra');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Maputra');
    }

}