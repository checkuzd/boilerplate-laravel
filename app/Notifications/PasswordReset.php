<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class PasswordReset extends Notification
{
    private string $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via(mixed $notifiable): array|string
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        $data = [
            'action' => $this->resetUrl($notifiable),
            'count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire'),
        ];

        return (new MailMessage)
            ->view('email.auth.reset-password', $data)
            ->subject(Lang::get('Reset Password Notification'));
    }

    protected function resetUrl(mixed $notifiable): string
    {
        return url(route('admin.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }
}
