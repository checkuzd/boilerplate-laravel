<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Permission;
use App\Models\Role;

class RoleService
{
    public function getAccessiblePermissions(Role $role): array
    {
        $data['restrictedPermissions'] = null;
        $permissions = Permission::has('children');
        if (auth()->user()->hasRole('Super Admin')) {
            $roles = new \stdClass();
            $roles->access_to = Role::all();
            $data['roles'] = $roles;
            $data['permissions'] = $permissions->with('children')->get();
        } else {
            $availablePermissions = $role->getAllPermissions()->pluck('id');

            $data['restrictedPermissions'] = $availablePermissions->diff(auth()->user()->getAllPermissions()->pluck('id'));
            $availablePermissions = $availablePermissions->merge(auth()->user()->getAllPermissions()->pluck('id'))->unique();

            $data['permissions'] = $permissions->with([
                'children' => fn ($query) => $query->whereIn('id', $availablePermissions),
            ])->get();
            $data['roles'] = Role::currentUserCanManageRoles()->first();
        }
        $data['abilities'] = $role->access_to()->pluck('id');
        $data['role'] = $role;

        return $data;
    }

    public function storeUserRole($data)
    {
        $permissions = $data->only('permissions');
        $permissions = (isset($permissions['permissions'])) ? $permissions['permissions'] : null;
        if (! auth()->user()->hasRole('Super Admin')) {
            $this->checkPermissions($permissions);
        }

        $role = Role::create($data->only('name', 'title'));
        $role->syncPermissions($data->only('permissions'));
        $this->addAccessToRoles($role, $data->input('roles'));

        return $role;
    }

    public function updateUserRole($data, Role $role): void
    {
        $permissions = $data->only('permissions');
        $permissions = (isset($permissions['permissions'])) ? $permissions['permissions'] : null;
        if (! auth()->user()->hasRole('Super Admin')) {
            $permissions = $this->checkWithRestrictedPermissions($role, $permissions);
        }

        $role->update($data->only('name', 'title'));
        $role->syncPermissions($permissions);
        $this->addAccessToRoles($role, $data->input('roles'));
    }

    private function checkPermissions($permissions)
    {
        if (isset($permissions)) {
            sort($permissions);

            $userPermissions = auth()->user()->getAllPermissions()->pluck('name')->sort()->values()->all();

            if (! empty(array_diff($permissions, $userPermissions))) {
                throw new \Exception('Added Permission not found!');
            }
        }

        return true;
    }

    private function checkWithRestrictedPermissions(Role $role, $requestedPermissions)
    {
        $rolePermissions = $role->getAllPermissions()->pluck('name');
        $restrictedPermissions = $rolePermissions->diff(auth()->user()->getAllPermissions()->pluck('name'))->toArray();

        if (isset($requestedPermissions)) {
            sort($requestedPermissions);

            $userPermissions = auth()->user()->getAllPermissions()->pluck('name');

            $userPermissions = $userPermissions->merge($restrictedPermissions)->sort()->values()->all();

            if (! empty(array_diff($requestedPermissions, $userPermissions))) {
                throw new \Exception('Added Permission not found!');
            }

            $permissions['permissions'] = array_merge($restrictedPermissions, $requestedPermissions);
        } else {
            $permissions['permissions'] = $restrictedPermissions;
        }

        return $permissions;
    }

    private function addAccessToRoles(Role $role, $addAccessRoles): void
    {
        if (auth()->user()->hasRole('Super Admin')) {
            $role->access_to()->sync($addAccessRoles);
        } else {
            $roles = Role::currentUserCanManageRoles()->first();

            $accessibleRoles = $roles->access_to()->pluck('id')->toArray();
            $currentAccessibleRole = $role->access_to()->pluck('id')->toArray();

            $sortedRoles = $addAccessRoles ? array_intersect($accessibleRoles, $addAccessRoles) : [];
            $restrictedRoles = $currentAccessibleRole ? array_diff($currentAccessibleRole, $addAccessRoles) : [];

            $sortedRoles = $sortedRoles + $restrictedRoles;
            $role->access_to()->sync($sortedRoles);

            $currentUserRole = Role::find(auth()->user()->getRoleId());
            $currentUserRole->access_to()->detach($role->id);
            $currentUserRole->access_to()->attach($role->id);
        }
    }
}
