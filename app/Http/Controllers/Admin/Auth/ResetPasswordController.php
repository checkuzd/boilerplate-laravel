<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as RulesPassword;

class ResetPasswordController extends Controller
{
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

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );
        } catch (Exception $e) {
            $status = 'Sorry, we are currently facing issues, contact us directly via mail.';
        }

        return $status === Password::RESET_LINK_SENT
            ? back()->withInput($request->only('email'))->with(['status' => __($status)])
            : back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
    }

    public function resetForgotPassword(Request $request)
    {
        return view('admin.auth.reset-password', ['request' => $request]);
    }

    public function createNewPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('admin.login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
