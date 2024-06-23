<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => ['required', 'max:255', 'email', 'unique:users,email,'.auth()->user()->id],
            'password' => 'nullable|min:8|confirmed|required_unless:current_password,null',
            'current_password' => 'nullable|current_password|required_unless:password,null',
            'avatar' => 'image|max:1024|sometimes',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required_unless' => 'The new password field is required when current password is not set.',
            'current_password.required_unless' => 'The current password field is required when password is set.',
        ];
    }
}
