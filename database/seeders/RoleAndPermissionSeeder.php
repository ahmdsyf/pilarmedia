<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ADMINS
        $adminPermission1 = Permission::create(['name' => 'admin_read', 'description' => 'admin read']);

        // HOME
        $homeSidebar = Permission::create(['name' => 'home_sidebar', 'description' => 'home sidebar']);

        // MASTER
        $masterSidebar = Permission::create(['name' => 'master_sidebar', 'description' => 'master admin']);
        $userSidebar = Permission::create(['name' => 'user_sidebar', 'description' => 'user admin']);
        $roleSidebar = Permission::create(['name' => 'role_sidebar', 'description' => 'role admin']);
        $permissionSidebar = Permission::create(['name' => 'permission_sidebar', 'description' => 'permission admin']);

        // USER MODEL
        $userPermission1 = Permission::create(['name' => 'user_list', 'description' => 'user list']);
        $userPermission2 = Permission::create(['name' => 'user_create', 'description' => 'user create']);
        $userPermission3 = Permission::create(['name' => 'user_edit', 'description' => 'user edit']);
        $userPermission4 = Permission::create(['name' => 'user_delete', 'description' => 'user delete']);

        // ROLE MODEL
        $rolePermission1 = Permission::create(['name' => 'role_list', 'description' => 'role list']);
        $rolePermission2 = Permission::create(['name' => 'role_create', 'description' => 'role create']);
        $rolePermission3 = Permission::create(['name' => 'role_edit', 'description' => 'role edit']);
        $rolePermission4 = Permission::create(['name' => 'role_delete', 'description' => 'role delete']);

        // PERMISSION MODEL
        $permission1 = Permission::create(['name' => 'permission_list', 'description' => 'permission list']);
        $permission2 = Permission::create(['name' => 'permission_create', 'description' => 'permission create']);
        $permission3 = Permission::create(['name' => 'permission_edit', 'description' => 'permission edit']);
        $permission4 = Permission::create(['name' => 'permission_delete', 'description' => 'permission delete']);

        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $adminRole = Role::create(['name' => 'Admin']);
        $salesRole = Role::create(['name' => 'Sales']);

        $superAdminRole->syncPermissions([
            $adminPermission1,
            $homeSidebar,

            $masterSidebar,
            $userSidebar,
            $roleSidebar,
            $permissionSidebar,

            $userPermission1,
            $userPermission2,
            $userPermission3,
            $userPermission4,
            $rolePermission1,
            $rolePermission2,
            $rolePermission3,
            $rolePermission4,
            $permission1,
            $permission2,
            $permission3,
            $permission4,
        ]);

         $adminRole->syncPermissions([
            $adminPermission1,
            $homeSidebar,

            $masterSidebar,
            $userSidebar,
            $roleSidebar,
            $permissionSidebar,

            $userPermission1,
            $userPermission2,
            $userPermission3,
            $userPermission4,
            $rolePermission1,
            $rolePermission2,
            $rolePermission3,
            $rolePermission4,
            $permission1,
            $permission2,
            $permission3,
            $permission4,
        ]);

        $salesRole->syncPermissions([
            $homeSidebar
        ]);

        $superAdmin = User::create([
            'name' => 'super admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('p@ssw0rd'),
            'remember_token' => Str::random(10),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),

        ]);

        $sales = User::create([
            'name' => 'sales',
            'email' => 'sales@gmail.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        $superAdmin->syncRoles($superAdminRole);

        $admin->syncRoles($adminRole);

        $sales->syncRoles($salesRole);

    }
}
