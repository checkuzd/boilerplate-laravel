<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (auth()->user()) {
            return redirect(route('admin.dashboard'));
        }

        return view('admin.auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $user = User::where(['email' => $request->username])
            ->orWhere(['username' => $request->username])
            ->status()
            ->first();

        if (! $user) {
            return back()
                ->withErrors(['username' => ['The username/email does not match our records.']])
                ->withInput($request->all());
        } elseif (! Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => ['The provided password does not match our records.']])
                ->withInput($request->all());
        }

        if (! $user->can('admin-dashboard')) {
            return back()->withErrors(['username' => ['You are in the wrong place!!!']])
                ->withInput($request->all());
        }

        Auth::login($user, $request->remember);

        return redirect()->route('admin.dashboard');
    }

    public function forgotPassword(): View
    {
        return view('admin.auth.forgot-password');
    }

    public function sendForgotPassword(Request $request)
    {
        $user = User::where(['email' => $request->email])
            ->status()
            ->first();

        if (! $user) {
            return back()
                ->withErrors(['email' => ['We can\'t find a user with that email address.']])
                ->withInput($request->all());
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);

    }

    public function resetForgotPassword()
    {
        return 'test';
        // return view('auth.reset-password', ['request' => $request]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
