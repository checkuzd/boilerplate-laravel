<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\Menu\Menu;
use App\Models\Menu\MenuItem;
use App\Services\RouteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        $menus = Menu::all();

        return view('admin.menu.index', compact('menus'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'location' => 'string|nullable',
        ]);

        $menu = Menu::create($validatedData);

        return to_route('admin.menus.edit', $menu)->with('success', 'Menu added successfully');
    }

    public function edit(Menu $menu): View
    {
        $menu->load(['menuItems' => fn ($query) => $query->whereNull('menu_item_id')->with('children')->orderBy('order', 'ASC')]);

        $routeService = new RouteService(
            method: 'GET',
            exceptPath: 'api',
            name: '',
            path: '',
            domain: '',
            exceptVendor: true
        );

        $routes = Cache::rememberForever('admin-get-method-routes', function () use ($routeService) {
            $cache = $routeService->getMethodRoutes(Route::getRoutes());

            return $cache;
        });

        return view('admin.menu.edit', compact('menu', 'routes'));
    }

    public function update(Request $request, Menu $menu): string
    {
        $menu_items = json_decode($request->input('items'));

        foreach ($menu_items as $key => $menu_item) {
            $menu_item_id = (isset($menu_item->parent_id)) ? $menu_item->parent_id : null;
            MenuItem::updateOrCreate(
                ['id' => $key],
                ['order' => $menu_item->order, 'menu_item_id' => $menu_item_id],
            );
        }

        Cache::forget('menu-settings');

        return 'Menu Order updated successfully!';
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        if ($menu->location) {
            return redirect()->back()->with('error', 'Menu cannot be deleted! (Assigned to a location)');
        }
        $menu->delete();

        return redirect()->back()->with('success', 'Menu deleted successfully');
    }
}
