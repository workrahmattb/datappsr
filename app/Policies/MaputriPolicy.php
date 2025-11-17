<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Maputri;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaputriPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Maputri');
    }

    public function view(AuthUser $authUser, Maputri $maputri): bool
    {
        return $authUser->can('View:Maputri');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Maputri');
    }

    public function update(AuthUser $authUser, Maputri $maputri): bool
    {
        return $authUser->can('Update:Maputri');
    }

    public function delete(AuthUser $authUser, Maputri $maputri): bool
    {
        return $authUser->can('Delete:Maputri');
    }

    public function restore(AuthUser $authUser, Maputri $maputri): bool
    {
        return $authUser->can('Restore:Maputri');
    }

    public function forceDelete(AuthUser $authUser, Maputri $maputri): bool
    {
        return $authUser->can('ForceDelete:Maputri');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Maputri');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Maputri');
    }

    public function replicate(AuthUser $authUser, Maputri $maputri): bool
    {
        return $authUser->can('Replicate:Maputri');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Maputri');
    }

}