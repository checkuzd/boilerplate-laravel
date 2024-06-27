<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\Menu\MenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MenuItemController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'menu_id' => 'required',
            'type' => 'required',
            'icon' => 'nullable',
            'route' => 'nullable',
        ]);

        $validatedData['order'] = MenuItem::where('menu_id', $request->menu_id)
            ->whereNull('menu_item_id')
            ->max('order') + 1;

        $menuItem = MenuItem::create($validatedData);

        Cache::forget('menu-settings');

        return response()->json([
            'msg' => 'Menu Item addded successfully!',
            'view' => view('admin.ajax.menu.menu-item', compact('menuItem'))->render(),
        ]);
    }

    public function edit(MenuItem $menuItem)
    {
        return view('admin.ajax.menu.edit-menu-item', compact('menuItem'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'icon' => 'nullable',
            'route' => 'required',
        ]);

        $menuItem->update($validatedData);

        Cache::forget('menu-settings');

        return 'Menu Item updated successfully';
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        Cache::forget('menu-settings');

        return 'Menu Item removed';
    }
}
