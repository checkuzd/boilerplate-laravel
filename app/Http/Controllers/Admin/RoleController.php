<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    public function index(): View
    {
        if (auth()->user()->hasRole('super-admin')) {
            $roles = Role::where('name', '!=', 'super-admin')->get();
        } else {
            /*
            to don't show the roles even if the current role has been given access to manage
            $roles = Role::withWhereHas('access_to', fn ($query) => $query->where('id', '!=', auth()->user()->getRoleId()))
             */
            $roles = Role::with(['access_to' => function ($query) {
                $query->where('id', '!=', auth()->user()->getRoleId())
                    ->orderBy('access_child_id', 'asc');
            }])
                ->where('id', auth()->user()->getRoleId())
                ->first();
            $roles = $roles->access_to;
        }

        return view('admin.role.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = Permission::has('children')->with('children')->get();

        if (auth()->user()->hasRole('super-admin')) {
            $roles = Role::all();
        } else {
            $roles = Role::with(['access_to' => fn ($query) => $query->orderBy('access_child_id', 'asc')])
                ->where('id', auth()->user()->getRoleId())
                ->first();
            $roles = $roles->access_to;
        }

        return view('admin.role.create', compact('permissions', 'roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'title' => 'required|unique:roles,title',
            'permissions' => 'sometimes',
        ]);

        $role = Role::create(request()->only('name', 'title'));
        $role->syncPermissions(request()->only('permissions'));

        $current_user_role = Role::find(auth()->user()->getRoleId());

        $current_user_role->access_to()->attach($role->id);

        return to_route('admin.roles.edit', $role)->with('success', 'Role added successfully');
    }

    public function edit(Role $role): View
    {
        $permissions = Permission::has('children')->with('children')->get();

        if (auth()->user()->hasRole('super-admin')) {
            $roles = new \stdClass();
            $roles->access_to = Role::all();
        } else {
            $roles = Role::with(['access_to' => fn ($query) => $query->orderBy('access_child_id', 'asc')])
                ->where('id', auth()->user()->getRoleId())
                ->first();
        }
        $abilities = $role->access_to()->pluck('id');

        return view('admin.role.edit', compact('permissions', 'roles', 'role', 'abilities'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
            'title' => 'required|unique:roles,title,'.$role->id,
            'permissions' => 'sometimes',
        ]);

        if (auth()->user()->hasRole('super-admin')) {
            $role->access_to()->sync(request()->input('roles'));
        } else {
            $roles = Role::with(['access_to' => fn ($query) => $query->orderBy('access_child_id', 'asc')])
                        ->where('id', auth()->user()->getRoleId())
                        ->first();

            $abilities = $roles->access_to()->pluck('id')->toArray();

            $result = null;
            if (request()->input('roles')) {
                $result = array_intersect($abilities, request()->input('roles'));
            }

            $role->access_to()->sync($result);
        }

        $role->update(request()->only('name', 'title'));
        $role->syncPermissions(request()->only('permissions'));

        return to_route('admin.roles.edit', $role)->with('success', 'Role updated successfully');
    }
}
