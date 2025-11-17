<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Mtsputra;
use Illuminate\Auth\Access\HandlesAuthorization;

class MtsputraPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Mtsputra');
    }

    public function view(AuthUser $authUser, Mtsputra $mtsputra): bool
    {
        return $authUser->can('View:Mtsputra');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Mtsputra');
    }

    public function update(AuthUser $authUser, Mtsputra $mtsputra): bool
    {
        return $authUser->can('Update:Mtsputra');
    }

    public function delete(AuthUser $authUser, Mtsputra $mtsputra): bool
    {
        return $authUser->can('Delete:Mtsputra');
    }

    public function restore(AuthUser $authUser, Mtsputra $mtsputra): bool
    {
        return $authUser->can('Restore:Mtsputra');
    }

    public function forceDelete(AuthUser $authUser, Mtsputra $mtsputra): bool
    {
        return $authUser->can('ForceDelete:Mtsputra');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Mtsputra');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Mtsputra');
    }

    public function replicate(AuthUser $authUser, Mtsputra $mtsputra): bool
    {
        return $authUser->can('Replicate:Mtsputra');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Mtsputra');
    }

}