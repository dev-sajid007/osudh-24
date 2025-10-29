<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            ['name' => 'view_users', 'display_name' => 'View Users', 'description' => 'Can view users list'],
            ['name' => 'create_users', 'display_name' => 'Create Users', 'description' => 'Can create new users'],
            ['name' => 'edit_users', 'display_name' => 'Edit Users', 'description' => 'Can edit existing users'],
            ['name' => 'delete_users', 'display_name' => 'Delete Users', 'description' => 'Can delete users'],

            ['name' => 'view_roles', 'display_name' => 'View Roles', 'description' => 'Can view roles list'],
            ['name' => 'create_roles', 'display_name' => 'Create Roles', 'description' => 'Can create new roles'],
            ['name' => 'edit_roles', 'display_name' => 'Edit Roles', 'description' => 'Can edit existing roles'],
            ['name' => 'delete_roles', 'display_name' => 'Delete Roles', 'description' => 'Can delete roles'],

            ['name' => 'view_dashboard', 'display_name' => 'View Dashboard', 'description' => 'Can view dashboard'],
            ['name' => 'manage_settings', 'display_name' => 'Manage Settings', 'description' => 'Can manage system settings']
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        // Create roles
        $adminRole = Role::firstOrCreate([
            'name' => 'admin'
        ], [
            'display_name' => 'Administrator',
            'description' => 'Full access to all features'
        ]);

        $managerRole = Role::firstOrCreate([
            'name' => 'manager'
        ], [
            'display_name' => 'Manager',
            'description' => 'Can manage users and leads'
        ]);

        $userRole = Role::firstOrCreate([
            'name' => 'user'
        ], [
            'display_name' => 'User',
            'description' => 'Basic user access'
        ]);

        // Assign permissions to roles
        // Admin gets all permissions
        $adminRole->permissions()->sync(Permission::all());

        // Manager gets limited permissions
        $managerPermissions = Permission::whereIn('name', [
            'view_dashboard',
            'view_users',
            'edit_users',
            'view_leads',
            'create_leads',
            'edit_leads',
            'delete_leads'
        ])->get();
        $managerRole->permissions()->sync($managerPermissions);

        // User gets basic permissions
        $userPermissions = Permission::whereIn('name', [
            'view_dashboard',
            'view_leads'
        ])->get();
        $userRole->permissions()->sync($userPermissions);

        // Assign admin role to the admin user
        $adminUser = User::where('email', 'admin@gmail.com')->first();
        if ($adminUser) {
            $adminUser->assignRole($adminRole);
        }

        // Assign roles to other users randomly for demo
        $users = User::where('email', '!=', 'admin@gmail.com')->get();
        $roles = [$managerRole, $userRole];

        foreach ($users as $user) {
            if (!$user->roles()->exists()) {
                $randomRole = $roles[array_rand($roles)];
                $user->assignRole($randomRole);
            }
        }
    }
}
