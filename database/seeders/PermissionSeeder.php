<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            // Patient
            'view patients',
            'create patients',
            'edit patients',
            'delete patients',

            // Student
            'view students',
            'create students',
            'edit students',
            'delete students',

            // Invoice
            'view invoices',
            'create invoices',
            'edit invoices',
            'delete invoices',

            // Appointment
            'manage appointments',

            // Messages
            'send messages',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Assign all permissions to admin
        $admin->syncPermissions(Permission::all());

        // Assign limited permissions to user
        $user->syncPermissions([
            'view patients',
            'create patients',
            'view students',
            'create students',
            'view invoices',
            'send messages',
        ]);
    }
}