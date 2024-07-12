<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Menu\Menu;
use Illuminate\Support\Facades\Cache;

class MenuService
{
    private function loadMenuItems($location)
    {
        return Menu::query()->where(['location' => $location])->with(['menuItems' => function ($query) {
            $query->whereNull('menu_item_id')->with('children')->orderBy('order', 'ASC');
        }])->first();
    }

    public function displayAdminMenu($location)
    {
        $menu = Cache::rememberForever('menu-settings', function () use ($location) {
            return $this->loadMenuItems($location);
        });

        return Cache::rememberForever('menu-view-'.auth()->user()->getRoleId(), function () use ($menu) {
            return view('layouts.partials.dynamic-menu', compact('menu'))->render();
        });
    }
}
