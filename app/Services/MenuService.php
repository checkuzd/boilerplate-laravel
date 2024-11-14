<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Menu\Menu;
use Illuminate\Support\Facades\Cache;

class MenuService
{
    private function loadMenuItems($location): ?Menu
    {
        return Menu::query()->where(['location' => $location])->with(['menuItems' => function ($query) {
            $query->whereNull('menu_item_id')->with('children')->orderBy('order', 'ASC');
        }])->first();
    }

    public function displayAdminMenu($location): string
    {
        return Cache::rememberForever('menu-settings', function () use ($location) {
            $menu = $this->loadMenuItems($location);

            return view('layouts.partials.dynamic-menu', compact('menu'))->render();
        });

        // return Cache::rememberForever('menu-view-'.auth()->user()->getRoleId(), function () use ($menu) {
        //     return view('layouts.partials.dynamic-menu', compact('menu'))->render();
        // });
    }
}
