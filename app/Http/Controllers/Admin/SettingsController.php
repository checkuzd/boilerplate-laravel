<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
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

    public function update(Request $request): RedirectResponse
    {
        $data = $request->except(['_token', '_method', 'logo', 'logo-sm']);

        if($request->hasFile('logo')) {
            $request->validate([
                'logo' => 'nullable|image|max:1024',
            ]);

            $request->file('logo')->storeAs('public', 'logo.png');
        }

        if($request->hasFile('logo-sm')) {
            $request->validate([
                'logo-sm' => 'nullable|image|max:1024',
            ]);

            $request->file('logo-sm')->storeAs('public', 'logo-sm.png');
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget('site-settings');

        return redirect()->back()->with('success', 'Settings has been updated.');
    }
}
