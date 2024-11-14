<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResetPasswordRequest;
use App\Models\User;
use App\Notifications\PasswordReset;
use Exception;
use Illuminate\Auth\Events\PasswordReset as EventPasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function forgotPassword(): View
    {
        return view('admin.auth.forgot-password');
    }

    public function sendForgotPassword(Request $request): RedirectResponse
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
                $request->only('email'), function ($user, $token) {
                    $user->notify(new PasswordReset($token));

                    return Password::RESET_LINK_SENT;
                }
            );
        } catch (Exception $e) {
            $status = 'Sorry, we are currently facing issues, contact us directly via mail.';
        }

        return $status === Password::RESET_LINK_SENT
            ? back()->withInput($request->only('email'))->with(['status' => __($status)])
            : back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
    }

    public function resetForgotPassword(Request $request): View
    {
        return view('admin.auth.reset-password', ['request' => $request]);
    }

    public function createNewPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => $request->password,
                    'remember_token' => Str::random(60),
                ])->save();

                event(new EventPasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? to_route('admin.login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
