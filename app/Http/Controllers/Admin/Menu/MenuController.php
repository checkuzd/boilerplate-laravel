<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\Menu\Menu;
use App\Models\Menu\MenuItem;
use App\Services\RouteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();

        return view('admin.menu.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'location' => 'string',
        ]);

        Menu::create($validatedData);

        return redirect(route('admin.menus.index'));
    }

    public function edit(Menu $menu)
    {
        $menu->load(['menuItems' => fn ($query) => $query->whereNull('menu_item_id')->with('children')->orderBy('order', 'ASC')]);

        $routeService = new RouteService('GET', 'api', '', '', '', true);
        $routes = $routeService->getMethodRoutes(Route::getRoutes());

        return view('admin.menu.edit', compact('menu', 'routes'));
    }

    public function update(Request $request, Menu $menu)
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

    public function destroy(Menu $menu)
    {
        if ($menu->location) {
            return redirect()->back()->with('error', 'Menu cannot be deleted');
        }
        $menu->delete();

        return redirect()->back()->with('success', 'Menu deleted successfully');
    }
}
