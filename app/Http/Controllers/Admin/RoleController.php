<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Services\Admin\RoleService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private RoleService $roleService;

    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');

        $this->roleService = new RoleService;
    }

    public function index(): View
    {
        return view('admin.role.index');
    }

    public function create()
    {
        $permissions = Permission::has('children');
        if (auth()->user()->hasRole(RoleEnum::SUPER_ADMIN)) {
            $roles = Role::all();
            $permissions = $permissions->with('children')->get();
        } else {
            $availablePermissions = auth()->user()->getAllPermissions()->pluck('id');

            $permissions = $permissions->with([
                'children' => fn ($query) => $query->whereIn('id', $availablePermissions),
            ])->get();

            $roles = Role::currentUserCanManageRoles()->first();
            $roles = $roles->access_to;
        }

        return view('admin.role.create', compact('permissions', 'roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'sometimes',
        ]);

        $role = $this->roleService->storeUserRole($request);

        return to_route('admin.roles.edit', $role)->with('success', 'Role added successfully');
    }

    public function edit(Role $role)
    {
        $data = $this->roleService->getAccessiblePermissions($role);

        return view('admin.role.edit', $data);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
            'permissions' => 'sometimes',
        ]);

        // try {
        $this->roleService->updateUserRole($request, $role);
        // } catch (\Throwable $e) {
        //     return back()->withErrors($e->getMessage());
        // }

        return to_route('admin.roles.edit', $role)->with('success', 'Role updated successfully');
    }

    public function destroy(Role $role): RedirectResponse
    {
        // $role->access_to()->sync($result);
        $role->delete();

        return redirect()->back()->with('success', 'Role deleted successfully');
    }
}
