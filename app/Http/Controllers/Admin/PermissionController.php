<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePermissionRequest;
use App\Http\Requests\Admin\UpdatePermissionRequest;
use App\Models\Permission;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PermissionController extends Controller
{
    public function index(): View
    {
        return view('admin.permission.index');
    }

    public function create(): View
    {
        $permissions = Permission::whereNull('permission_id')->get();

        return view('admin.permission.create', compact('permissions'));
    }

    public function store(StorePermissionRequest $request): RedirectResponse
    {
        $permission = Permission::create($request->validated());

        return to_route('admin.permissions.edit', $permission)->with('success', 'Permission added successfully');
    }

    public function edit(Permission $permission): View
    {
        $permissions = Permission::whereNull('permission_id')->get();

        return view('admin.permission.edit', compact('permission', 'permissions'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission): RedirectResponse
    {
        $permission->name = $request->name;
        $permission->permission_id = $request->permission_id;
        $permission->save();

        return to_route('admin.permissions.edit', $permission)->with('success', 'Permission updated successfully');
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        if ($permission->children()->count()) {
            return redirect()->back()->with('error', 'Permission cannot be delete, it is a related permission');
        }
        $permission->delete();

        return redirect()->back()->with('success', 'Permission deleted successfully');
    }
}
