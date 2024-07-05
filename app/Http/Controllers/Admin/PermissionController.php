<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(): View
    {
        $permissions = Permission::with('parent')->get();

        return view('admin.permission.index', compact('permissions'));
    }

    public function create(): View
    {
        $permissions = Permission::whereNull('permission_id')->get();

        return view('admin.permission.create', compact('permissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:permissions,name',
            'permission_id' => 'nullable|exists:permissions,id',
        ]);

        $permission = Permission::create($validatedData);

        return to_route('admin.permissions.edit', $permission)->with('success', 'Permission added successfully');
    }

    public function edit(Permission $permission): View
    {
        $permissions = Permission::whereNull('permission_id')->get();

        return view('admin.permission.edit', compact('permission', 'permissions'));
    }

    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,'.$permission->id,
            'permission_id' => 'nullable|exists:permissions,id',
        ]);

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
