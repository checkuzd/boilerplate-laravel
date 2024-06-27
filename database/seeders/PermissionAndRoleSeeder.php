<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission_category = Permission::create(['name' => 'Miscellaneous']);
        Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'site-settings',
        ]);
        Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'menu-settings',
        ]);
        $permission_category = Permission::create(['name' => 'Role Management']);
        Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'access-permission',
        ]);
        Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'role-view-any',
        ]);
        Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'role-create',
        ]);
        Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'role-update',
        ]);
        Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'role-delete',
        ]);
        $permission_category = Permission::create(['name' => 'User Management']);
        Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'user-view-any',
        ]);
        Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'user-create',
        ]);
        Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'user-update',
        ]);
        Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'user-delete',
        ]);
    }
}
