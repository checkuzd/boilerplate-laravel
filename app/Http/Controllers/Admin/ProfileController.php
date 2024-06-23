<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile');
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $validatedData = $request->safe()->only(['first_name', 'last_name', 'email']);

        if ($request->input('password')) {
            $validatedData['password'] = Hash::make($request->input('password'));
        }

        auth()->user()->update($validatedData);

        if ($request->hasFile('avatar')) {
            auth()->user()->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }

        return redirect()->back()->with('success', 'Your profile has been updated.');
    }
}
