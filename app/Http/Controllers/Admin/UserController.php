<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Notifications\UserRegistered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(): View
    {
        return view('admin.user.index');
    }

    public function create(): View
    {
        if (auth()->user()->hasRole('Super Admin')) {
            $roles = Role::all();
        } else {
            $roles = Role::currentUserCanManageRoles()->first();
            $roles = $roles->access_to;
        }

        return view('admin.user.create', compact('roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validatedData = request()->only(['first_name', 'username', 'email', 'password', 'role']);

        if (! auth()->user()->hasRole('Super Admin')) {
            $roles = Role::currentUserCanManageRoles()->first();

            $abilities = $roles->access_to()->pluck('id')->toArray();

            if (! in_array(request()->input('role'), $abilities)) {
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

        $status = Password::sendResetLink(
            $request->only('email'), function ($user, $token) {
                $user->notify(new UserRegistered($token));

                return Password::RESET_LINK_SENT;
            }
        );

        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }

        return redirect()
            ->route('admin.users.edit', $user)
            ->with('success', 'User added successfully');
    }

    public function edit(User $user): View
    {
        if (auth()->user()->hasRole('Super Admin')) {
            $roles = Role::all();
        } else {
            $roles = Role::currentUserCanManageRoles()->first();
            $roles = $roles->access_to;
        }

        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validatedData = request()->only(['first_name', 'last_name', 'username', 'email', 'role']);

        if (! auth()->user()->hasRole('Super Admin')) {
            $roles = Role::currentUserCanManageRoles()->first();

            $abilities = $roles->access_to()->pluck('id')->toArray();

            if (! in_array(request()->input('role'), $abilities)) {
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
            ->route('admin.users.edit', $user)
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully');
    }
}
