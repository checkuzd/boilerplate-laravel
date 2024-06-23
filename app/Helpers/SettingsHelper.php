<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsHelper
{
    public static function get($field)
    {
        $siteSetting = Cache::rememberForever('site-settings', function () {
            return Setting::all()->keyBy('key');
        });

        return $siteSetting->where('key', $field)->value('value');
    }

    public static function logo()
    {
        if (Storage::disk('public')->exists('logo.png')) {
            return Storage::url('logo.png');
        }

        return config('app.url').Storage::url('placeholder/logo.png');
    }

    public static function getTimeNow()
    {
        return time();
    }
}
