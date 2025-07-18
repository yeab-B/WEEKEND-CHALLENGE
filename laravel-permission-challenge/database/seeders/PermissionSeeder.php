<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Define all permissions
        $permissions = [
            // Post permissions
            'create post',
            'view post',
            'update post',
            'delete post',
            'approve post',
             'view article',
            'create article',
            'update article',
            'delete article',
            'approve article',
            'view articles', 
            'create articles',
            'update articles',
            'delete articles',
            'approve articles',

            // User management
            'create user',
            'view user',
            'update user',
            'delete user',

            // Role management
            'create role',
            'view role',
            'update role',
            'delete role',
            'create roles',
            'view roles',
            'update roles',
            'delete roles',

            // Permission management
            'create permission',
            'view permission',
            'update permission',
            'delete permission',
             'create permissions',
            'view permissions',
            'update permissions',
            'delete permissions',
            'create permissions',
            'view permissions',
            'update permissions',
            'delete permissions',
        ];

        // Create or update permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create or update roles
        $admin   = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $viewer  = Role::firstOrCreate(['name' => 'viewer', 'guard_name' => 'web']);
        $editor  = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $blogger = Role::firstOrCreate(['name' => 'blogger', 'guard_name' => 'web']);

        // Assign permissions
        $admin->syncPermissions(Permission::all());

        $viewer->syncPermissions([
            'view post',
        ]);

        $editor->syncPermissions([
            'view articles',
            'update articles',
        ]);

        $blogger->syncPermissions([
            'create articles',
            'view articles',
        ]);
    }
}
