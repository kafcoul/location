<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view_vehicles',
            'create_vehicles',
            'edit_vehicles',
            'delete_vehicles',

            'view_reservations',
            'create_reservations',
            'edit_reservations',
            'delete_reservations',
            'confirm_reservations',
            'cancel_reservations',

            'view_cities',
            'create_cities',
            'edit_cities',
            'delete_cities',

            'view_users',
            'create_users',
            'edit_users',
            'delete_users',

            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',

            'access_dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin = Role::firstOrCreate(['name' => User::ROLE_SUPER_ADMIN]);
        $superAdmin->syncPermissions(Permission::all());

        $admin = Role::firstOrCreate(['name' => User::ROLE_ADMIN]);
        $admin->syncPermissions([
            'view_vehicles',
            'create_vehicles',
            'edit_vehicles',
            'delete_vehicles',
            'view_reservations',
            'create_reservations',
            'edit_reservations',
            'delete_reservations',
            'confirm_reservations',
            'cancel_reservations',
            'view_cities',
            'create_cities',
            'edit_cities',
            'delete_cities',
            'view_users',
            'edit_users',
            'access_dashboard',
        ]);

        $manager = Role::firstOrCreate(['name' => User::ROLE_MANAGER]);
        $manager->syncPermissions([
            'view_vehicles',
            'create_vehicles',
            'edit_vehicles',
            'view_reservations',
            'create_reservations',
            'edit_reservations',
            'confirm_reservations',
            'cancel_reservations',
            'view_cities',
            'access_dashboard',
        ]);

        $support = Role::firstOrCreate(['name' => User::ROLE_SUPPORT]);
        $support->syncPermissions([
            'view_vehicles',
            'view_reservations',
            'edit_reservations',
            'confirm_reservations',
            'view_cities',
            'access_dashboard',
        ]);

        $adminUser = User::where('email', 'admin@ckfmotors.com')->first();
        if ($adminUser) {
            $adminUser->syncRoles([User::ROLE_SUPER_ADMIN]);
        }
    }
}
