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

        MenuItem::create([
            'name' => 'Management',
            'type' => 'label',
            'order' => 1,
            'menu_id' => $adminMenu->id,
        ]);

        $usersMenuItem = MenuItem::create([
            'name' => 'Users',
            'icon' => 'mdi-account-group',
            'type' => 'label',
            'order' => 2,
            'menu_id' => $adminMenu->id,
        ]);
        $rolesMenuItem = MenuItem::create([
            'name' => 'Roles',
            'icon' => 'mdi-shield-account',
            'type' => 'label',
            'order' => 3,
            'menu_id' => $adminMenu->id,
        ]);
        $permissionsMenuItem = MenuItem::create([
            'name' => 'Permissions',
            'icon' => 'mdi-account-lock-open',
            'type' => 'label',
            'order' => 4,
            'menu_id' => $adminMenu->id,
        ]);

        MenuItem::create([
            'name' => 'Components',
            'type' => 'label',
            'order' => 5,
            'menu_id' => $adminMenu->id,
        ]);

        MenuItem::create([
            'name' => 'Menus',
            'route' => 'admin.menus.index',
            'icon' => 'mdi-menu',
            'type' => 'route_name',
            'order' => 6,
            'menu_id' => $adminMenu->id,
        ]);

        MenuItem::create([
            'name' => 'Settings',
            'route' => 'admin.settings.edit',
            'icon' => 'mdi-cog',
            'type' => 'route_name',
            'order' => 7,
            'menu_id' => $adminMenu->id,
        ]);

        $menus = [
            [
                'name' => 'All Users',
                'route' => 'admin.users.index',
                'type' => 'route_name',
                'order' => 0,
                'menu_item_id' => $usersMenuItem->id,
            ],
            [
                'name' => 'Add New User',
                'route' => 'admin.users.create',
                'type' => 'route_name',
                'order' => 1,
                'menu_item_id' => $usersMenuItem->id,
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
            ],
            [
                'name' => 'Add New Role',
                'route' => 'admin.roles.create',
                'type' => 'route_name',
                'order' => 1,
                'menu_item_id' => $rolesMenuItem->id,
            ],
            [
                'name' => 'All Permissions',
                'route' => 'admin.permissions.index',
                'type' => 'route_name',
                'order' => 0,
                'menu_item_id' => $permissionsMenuItem->id,
            ],
            [
                'name' => 'Add New Permission',
                'route' => 'admin.permissions.create',
                'type' => 'route_name',
                'order' => 1,
                'menu_item_id' => $permissionsMenuItem->id,
            ],
        ];

        foreach ($menus as $key => $menu) {
            MenuItem::create([
                'name' => $menu['name'],
                'route' => $menu['route'],
                'type' => $menu['type'],
                'order' => $menu['order'],
                'menu_item_id' => $menu['menu_item_id'],
                'menu_id' => $adminMenu->id,
            ]);
        }
    }
}
