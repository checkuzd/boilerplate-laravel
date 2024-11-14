<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Menu\StoreMenuItemRequest;
use App\Http\Requests\Admin\Menu\UpdateMenuItemRequest;
use App\Models\Menu\MenuItem;
use App\Models\Permission;
use App\Models\Role;
use App\Services\RouteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    public function store(StoreMenuItemRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $validatedData['order'] = MenuItem::where('menu_id', $request->menu_id)
            ->whereNull('menu_item_id')
            ->max('order') + 1;

        $menuItem = MenuItem::create($validatedData);

        Cache::forget('menu-settings');
        Cache::forget('menu-view-'.auth()->user()->getRoleId());

        return response()->json([
            'msg' => 'Menu Item addded successfully!',
            'view' => view('admin.ajax.menu.menu-item', compact('menuItem'))->render(),
        ]);
    }

    public function edit(MenuItem $menuItem): View
    {
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

        $permissions = Permission::has('children')->with('children')->get();

        return view('admin.ajax.menu.edit-menu-item', compact('menuItem', 'routes', 'permissions'));
    }

    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem): JsonResponse
    {
        $permissions = $request->only('permissions');
        $menuItem->update($request->except('permissions'));
        $menuItem->permissions()->sync($permissions['permissions'] ?? null);

        defer(
            function () {
                Cache::forget('menu-settings');
                // $roles = Role::select('id')->get();
                // $roles->each(function ($role) {
                //     Cache::forget('menu-view-'.$role->id);
                // });
            }
        )->always();

        $data = [
            'msg' => __('Menu Item updated successfully'),
            'data' => $menuItem,
        ];

        return response()->json($data);
    }

    public function destroy(MenuItem $menuItem): string
    {
        $menuItem->delete();
        Cache::forget('menu-settings');
        // Cache::forget('menu-view-'.auth()->user()->getRoleId());

        return 'Menu Item removed';
    }
}
