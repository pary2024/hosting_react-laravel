<?php
// database/seeders/PermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Patients
            'view patients', 'create patients', 'edit patients', 'delete patients',

            // Students
            'view students', 'create students', 'edit students', 'delete students',

            // Invoices
            'view invoices', 'create invoices', 'edit invoices', 'delete invoices',

            // Appointments
            'manage appointments',

            // Messages
            'send messages',

            // Users
            'view users', 'create users', 'edit users', 'delete users',

            // Schools
            'view schools', 'create schools', 'edit schools', 'delete schools',

            // Companies
            'view companies', 'create companies', 'edit companies', 'delete companies',
        ];

        // Create permissions if they don't exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles if they don't exist
        $superAdmin = Role::firstOrCreate(['name' => 'super admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Assign all permissions to superAdmin
        $superAdmin->syncPermissions($permissions);

        // Permissions for admin
        $adminPermissions = [
            // Patients
            'view patients', 'create patients', 'edit patients', 'delete patients',

            // Invoices
            'view invoices', 'create invoices', 'edit invoices', 'delete invoices',

            // Appointments
            'manage appointments',
            // Users
            'view users', 'create users', 'edit users', 'delete users',

           
        ];
        $admin->syncPermissions($adminPermissions);

        // Permissions for user
        $userPermissions = [
            'view patients', 'create patients',
            'view invoices',
            'send messages',
        ];
        $user->syncPermissions($userPermissions);

        // Clear cache again
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}