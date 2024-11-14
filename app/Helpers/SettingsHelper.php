<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Enums\RoleEnum;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsHelper
{
    public static function get($field): mixed
    {
        $siteSetting = Cache::rememberForever('site-settings', function () {
            return Setting::all()->keyBy('key');
        });

        return $siteSetting->where('key', $field)->value('value');
    }

    public static function getFavicon(): string
    {
        if (Storage::disk('public')->exists('favicon.ico')) {
            return Storage::url('favicon.ico');
        }

        return config('app.url').Storage::url('placeholder/favicon.ico');
    }

    public static function logo($logoType = ''): string
    {
        if ($logoType == 'favicon') {
            return self::getFavicon();
        }
        if ($logoType == 'logo-sm' && Storage::disk('public')->exists('logo-sm.png')) {
            return Storage::url('logo-sm.png');
        }
        if (Storage::disk('public')->exists('logo.png')) {
            return Storage::url('logo.png');
        }

        return config('app.url').Storage::url('placeholder/logo.png');
    }

    public static function getTimeNow(): int
    {
        return time();
    }

    public static function checkPermission($permissions)
    {
        if (auth()->user()->hasAnyPermission($permissions) || auth()->user()->hasRole(RoleEnum::SUPER_ADMIN)) {
            return true;
        }
    }
}
