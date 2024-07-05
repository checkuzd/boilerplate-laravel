<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:site-settings']);
    }

    public function edit(): View
    {
        return view('admin.settings');
    }

    public function update(Request $request, SettingsService $settingsService): RedirectResponse
    {
        $data = $request->except(['_token', '_method', 'logo', 'logo-sm', 'favicon']);

        $request->validate([
            'logo' => 'image|max:1024',
            'logo-sm' => 'image|max:1024',
            'favicon' => 'mimes:ico|max:1024',
            'email_address' => 'required|email|max:100',
        ]);

        if ($request->hasFile('logo')) {
            $settingsService->storeFile($request->file('logo'), 'logo.png');
        }
        if ($request->hasFile('logo-sm')) {
            $settingsService->storeFile($request->file('logo'), 'logo-sm.png');
        }
        if ($request->hasFile('favicon')) {
            $settingsService->storeFile($request->file('favicon'), 'favicon.ico');
        }
        // $request->file('logo')->storeAs('public', 'logo.png');
        // $request->file('logo-sm')->storeAs('public', 'logo-sm.png');
        // $request->file('logo-sm')->storeAs('public', 'logo-sm.png');

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget('site-settings');

        return redirect()->back()->with('success', 'Settings has been updated.');
    }
}
