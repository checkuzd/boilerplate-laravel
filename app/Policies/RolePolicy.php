<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        if ($user->can('role-view-any')) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        if ($user->can('role-create')) {
            return true;
        }

        return false;
    }

    public function update(User $user, Role $role): bool
    {
        if ($user->cannot('role-update') || $role->id == auth()->user()->getRoleId()) {
            return false;
        }

        $roles = Role::currentUserCanManageRoles()->first();

        if (! in_array($role->id, $roles->access_to->pluck('id')->toArray())) {
            return false;
        }

        return true;
    }

    public function delete(User $user, Role $role): bool
    {
        if ($user->can('role-delete')) {
            return true;
        }

        return false;
    }
}
