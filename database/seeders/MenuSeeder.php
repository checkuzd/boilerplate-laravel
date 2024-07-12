<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\MenuLocation;
use App\Models\Menu\Menu;
use App\Models\Menu\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $adminMenu = Menu::create([
            'name' => 'Admin Menu',
            'location' => MenuLocation::ADMIN,
        ]);

        $menuItem = MenuItem::create([
            'name' => 'Management',
            'type' => 'label',
            'order' => 1,
            'menu_id' => $adminMenu->id,
        ]);

        $menuItem->permissions()->sync([5]);

        $usersMenuItem = MenuItem::create([
            'name' => 'Users',
            'icon' => 'mdi-account-group',
            'type' => 'label',
            'order' => 2,
            'menu_id' => $adminMenu->id,
        ]);

        $usersMenuItem->permissions()->sync([14, 15]);

        $rolesMenuItem = MenuItem::create([
            'name' => 'Roles',
            'icon' => 'mdi-shield-account',
            'type' => 'label',
            'order' => 3,
            'menu_id' => $adminMenu->id,
        ]);

        $rolesMenuItem->permissions()->sync([9, 10]);

        $permissionsMenuItem = MenuItem::create([
            'name' => 'Permissions',
            'icon' => 'mdi-account-lock-open',
            'type' => 'label',
            'order' => 4,
            'menu_id' => $adminMenu->id,
        ]);

        $permissionsMenuItem->permissions()->sync([8]);

        $menuItem = MenuItem::create([
            'name' => 'Components',
            'type' => 'label',
            'order' => 5,
            'menu_id' => $adminMenu->id,
        ]);

        $menuItem->permissions()->sync([2, 3]);

        $menuItem = MenuItem::create([
            'name' => 'Menus',
            'route' => 'admin.menus.index',
            'icon' => 'mdi-menu',
            'type' => 'route_name',
            'order' => 6,
            'menu_id' => $adminMenu->id,
        ]);

        $menuItem->permissions()->sync([3]);

        $menuItem = MenuItem::create([
            'name' => 'Settings',
            'route' => 'admin.settings.edit',
            'icon' => 'mdi-cog',
            'type' => 'route_name',
            'order' => 7,
            'menu_id' => $adminMenu->id,
        ]);

        $menuItem->permissions()->sync([2]);

        $menus = [
            [
                'name' => 'All Users',
                'route' => 'admin.users.index',
                'type' => 'route_name',
                'order' => 0,
                'menu_item_id' => $usersMenuItem->id,
                'permissions' => [14],
            ],
            [
                'name' => 'Add New User',
                'route' => 'admin.users.create',
                'type' => 'route_name',
                'order' => 1,
                'menu_item_id' => $usersMenuItem->id,
                'permissions' => [15],
            ],
            [
                'name' => 'Profile',
                'route' => 'admin.profile.edit',
                'type' => 'route_name',
                'order' => 2,
                'menu_item_id' => $usersMenuItem->id,
            ],
            [
                'name' => 'All Roles',
                'route' => 'admin.roles.index',
                'type' => 'route_name',
                'order' => 0,
                'menu_item_id' => $rolesMenuItem->id,
                'permissions' => [9],
            ],
            [
                'name' => 'Add New Role',
                'route' => 'admin.roles.create',
                'type' => 'route_name',
                'order' => 1,
                'menu_item_id' => $rolesMenuItem->id,
                'permissions' => [10],
            ],
            [
                'name' => 'All Permissions',
                'route' => 'admin.permissions.index',
                'type' => 'route_name',
                'order' => 0,
                'menu_item_id' => $permissionsMenuItem->id,
                'permissions' => [8],
            ],
            [
                'name' => 'Add New Permission',
                'route' => 'admin.permissions.create',
                'type' => 'route_name',
                'order' => 1,
                'menu_item_id' => $permissionsMenuItem->id,
                'permissions' => [8],
            ],
        ];

        foreach ($menus as $key => $menu) {
            $menuItem = MenuItem::create([
                'name' => $menu['name'],
                'route' => $menu['route'],
                'type' => $menu['type'],
                'order' => $menu['order'],
                'menu_item_id' => $menu['menu_item_id'],
                'menu_id' => $adminMenu->id,
            ]);
            if (isset($menu['permissions'])) {
                $menuItem->permissions()->sync($menu['permissions']);
            }
        }
    }
}
