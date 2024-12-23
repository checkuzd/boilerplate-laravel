<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_permission = [];
        $customer_permission = [];
        $permission_category = Permission::create(['name' => 'Miscellaneous']);
        Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'site-settings',
        ]);
        Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'menu-settings',
        ]);
        $permission_category = Permission::create(['name' => 'Accessablity']);
        $admin_permission[] = Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'admin-dashboard',
        ]);
        $customer_permission[] = Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'customer-dashboard',
        ]);
        $permission_category = Permission::create(['name' => 'Role Management']);
        Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'access-permission',
        ]);
        $admin_permission[] = Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'role-view-any',
        ]);
        $admin_permission[] = Permission::create([
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
        $admin_permission[] = Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'user-view-any',
        ]);
        $admin_permission[] = Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'user-create',
        ]);
        $admin_permission[] = Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'user-update',
        ]);
        $admin_permission[] = Permission::create([
            'permission_id' => $permission_category->id,
            'name' => 'user-delete',
        ]);
        $product_category = Permission::create(['name' => 'Product Management']);
        $admin_permission[] = Permission::create([
            'permission_id' => $product_category->id,
            'name' => 'product-view-any',
        ]);
        $admin_permission[] = Permission::create([
            'permission_id' => $product_category->id,
            'name' => 'product-create',
        ]);
        $admin_permission[] = Permission::create([
            'permission_id' => $product_category->id,
            'name' => 'product-update',
        ]);
        $admin_permission[] = Permission::create([
            'permission_id' => $product_category->id,
            'name' => 'product-delete',
        ]);

        Role::create(['name' => RoleEnum::SUPER_ADMIN]);
        $admin = Role::create(['name' => RoleEnum::ADMIN]);
        $customer = Role::create(['name' => RoleEnum::CUSTOMER]);

        $admin->access_to()->sync([$admin->id, $customer->id]);

        foreach ($admin_permission as $key => $permission) {
            $admin->givePermissionTo($permission->name);
        }
        foreach ($customer_permission as $key => $permission) {
            $customer->givePermissionTo($permission->name);
        }
    }
}
