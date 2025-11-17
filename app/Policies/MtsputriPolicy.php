<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Mtsputri;
use Illuminate\Auth\Access\HandlesAuthorization;

class MtsputriPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Mtsputri');
    }

    public function view(AuthUser $authUser, Mtsputri $mtsputri): bool
    {
        return $authUser->can('View:Mtsputri');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Mtsputri');
    }

    public function update(AuthUser $authUser, Mtsputri $mtsputri): bool
    {
        return $authUser->can('Update:Mtsputri');
    }

    public function delete(AuthUser $authUser, Mtsputri $mtsputri): bool
    {
        return $authUser->can('Delete:Mtsputri');
    }

    public function restore(AuthUser $authUser, Mtsputri $mtsputri): bool
    {
        return $authUser->can('Restore:Mtsputri');
    }

    public function forceDelete(AuthUser $authUser, Mtsputri $mtsputri): bool
    {
        return $authUser->can('ForceDelete:Mtsputri');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Mtsputri');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Mtsputri');
    }

    public function replicate(AuthUser $authUser, Mtsputri $mtsputri): bool
    {
        return $authUser->can('Replicate:Mtsputri');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Mtsputri');
    }

}