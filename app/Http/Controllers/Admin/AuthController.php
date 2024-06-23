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

class AuthController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (auth()->user()) {
            return redirect(route('admin.dashboard'));
        }

        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $user = User::where(['email' => $request->username])
                    ->orWhere(['username' => $request->username])
                    ->first();

        if (!$user) {
            return back()
                ->withErrors(['username' => ['The username/email does not match our records.']])
                ->withInput($request->all());
        } elseif (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => ['The provided password does not match our records.']])
                ->withInput($request->all());
        }

        Auth::login($user, $request->remember);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
