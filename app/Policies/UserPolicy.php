<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        if ($user->can('user-view-any')) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        if ($user->can('user-create')) {
            return true;
        }

        return false;
    }

    public function update(User $user, User $model): bool
    {
        if ($user->cannot('user-update') || $user->id == $model->id) {
            return false;
        }

        $role = Role::findById($user->getRoleId());
        if (! in_array($model->getRoleId(), $role->access_to()->pluck('id')->toArray())) {
            return false;
        }

        return true;
    }

    public function delete(User $user, User $model): bool
    {
        if ($user->cannot('user-delete') || $user->id == $model->id) {
            return false;
        }

        $role = Role::findById($user->getRoleId());
        if (! in_array($model->getRoleId(), $role->access_to()->pluck('id')->toArray())) {
            return false;
        }

        return true;
    }
}
