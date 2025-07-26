<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'create movies',
            'edit movies',
            'delete movies',
            'view movies',
            'rate movies',
            'comment on movies',
        ];

        // Create permissions if they don't exist
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Assign permissions to roles
        $adminRole->syncPermissions(Permission::all());

        $customerRole->syncPermissions([
            'view movies',
            'rate movies',
            'comment on movies',
        ]);

        // Create or update admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'), // Always hash passwords!
            ]
        );

        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Assign "customer" role to all users except admin
        $customerUsers = User::where('email', '!=', 'admin@example.com')->get();
        foreach ($customerUsers as $user) {
            if (!$user->hasRole('customer')) {
                $user->assignRole('customer');
            }
        }
    }
}
