<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): View
    {
        if (auth()->user()->hasRole('super-admin')) {
            $users = User::withWhereHas('roles')
                ->where('id', '!=', auth()->user()->id)
                ->get();
        } else {
            $roles = Role::with(['access_to' => fn ($query) => $query->orderBy('access_child_id', 'asc')])
                ->where('id', auth()->user()->getRoleId())
                ->first();
            $roles = $roles->access_to->pluck('id')->toArray();

            $users = User::with('roles')
                ->whereHas('roles', function ($query) use ($roles) {
                    $query->whereIn('id', $roles);
                })
                ->where('id', '!=', auth()->user()->id)
                ->get();
        }

        return view('admin.user.index', compact('users'));
    }

    public function create(): View
    {
        if (auth()->user()->hasRole('super-admin')) {
            $roles = Role::all();
        } else {
            $roles = Role::with(['access_to' => fn ($query) => $query->orderBy('access_child_id', 'asc')])
                ->where('id', auth()->user()->getRoleId())
                ->first();
            $roles = $roles->access_to;
        }

        return view('admin.user.create', compact('roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validatedData = request()->only(['first_name', 'username', 'email', 'password', 'role']);

        if (!auth()->user()->hasRole('super-admin')) {
            $roles = Role::with(['access_to' => fn ($query) => $query->orderBy('access_child_id', 'asc')])
                        ->where('id', auth()->user()->getRoleId())
                        ->first();

            $abilities = $roles->access_to()->pluck('id')->toArray();

            if (!in_array(request()->input('role'), $abilities)) {
                return back()
                    ->withErrors(['role' => ['Invald User role.']])
                    ->withInput($request->all());
            }
        }

        if ($request->input('password')) {
            $validatedData['password'] = Hash::make($request->input('password'));
        }

        $user = User::create($validatedData);

        $user->roles()->sync($request->input('role'));

        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User added successfully');
    }

    public function edit(User $user): View
    {
        if (auth()->user()->hasRole('super-admin')) {
            $roles = Role::all();
        } else {
            $roles = Role::with(['access_to' => fn ($query) => $query->orderBy('access_child_id', 'asc')])
                ->where('id', auth()->user()->getRoleId())
                ->first();
            $roles = $roles->access_to;
        }

        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validatedData = request()->only(['first_name', 'last_name', 'username', 'email', 'role']);

        if (!auth()->user()->hasRole('super-admin')) {
            $roles = Role::with(['access_to' => fn ($query) => $query->orderBy('access_child_id', 'asc')])
                ->where('id', auth()->user()->getRoleId())
                ->first();

            $abilities = $roles->access_to()->pluck('id')->toArray();

            if (!in_array(request()->input('role'), $abilities)) {
                return back()
                    ->withErrors(['role' => ['Invald User role.']])
                    ->withInput($request->all());
            }
        }

        if ($request->input('password')) {
            $validatedData['password'] = Hash::make($request->input('password'));
        }

        $user->update($validatedData);
        $user->roles()->sync($request->input('role'));

        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }
}
