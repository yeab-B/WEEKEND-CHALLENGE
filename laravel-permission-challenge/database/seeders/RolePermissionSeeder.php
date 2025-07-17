<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'create articles',
            'edit articles',
            'delete articles',
            'view articles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $editor = Role::firstOrCreate(['name' => 'Editor']);
        $viewer = Role::firstOrCreate(['name' => 'Viewer']);

        $admin->givePermissionTo(Permission::all());
        $editor->givePermissionTo(['create articles', 'edit articles', 'view articles']);
        $viewer->givePermissionTo(['view articles']);
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password')] // Use a strong password in production!
        );
        $adminUser->assignRole('Admin');
        $this->command->info('Admin user created/assigned: admin@example.com / password');
        $editorUser = User::firstOrCreate(
            ['email' => 'editor@example.com'],
            ['name' => 'Editor User', 'password' => bcrypt('password')]
        );
         $editorUser->assignRole('Editor');
        $this->command->info('Editor user created/assigned: editor@example.com / password');
         $viewerUser = User::firstOrCreate(
            ['email' => 'viewer@example.com'],
            ['name' => 'Viewer User', 'password' => bcrypt('password')]
        );
        $viewerUser->assignRole('Viewer');
        $this->command->info('Viewer user created/assigned: viewer@example.com / password');
    }
}
