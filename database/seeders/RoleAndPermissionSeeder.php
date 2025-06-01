<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Permission::truncate();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ['name' => 'list-users'],
            ['name' => 'delete-users'],

            ['name' => 'change-role'],
            ['name' => 'list-role'],
            ['name' => 'create-role'],
            ['name' => 'edit-role'],
            ['name' => 'delete-role'],

            ['name' => 'list-permission'],
            ['name' => 'create-permission'],
            ['name' => 'edit-permission'],
            ['name' => 'delete-permission'],

            ['name' => 'list-hotels'],
            ['name' => 'create-hotels'],
            ['name' => 'edit-hotels'],
            ['name' => 'delete-hotels'],

            ['name' => 'list-rooms'],
            ['name' => 'create-rooms'],
            ['name' => 'edit-rooms'],
            ['name' => 'delete-rooms'],

            ['name' => 'list-bookings'],
            ['name' => 'create-bookings'],
            ['name' => 'edit-bookings'],
            ['name' => 'delete-bookings'],

            ['name' => 'list-hotel-managers'],
            ['name' => 'create-hotel-managers'],
            ['name' => 'edit-hotel-managers'],
            ['name' => 'delete-hotel-managers'],

            ['name' => 'list-hotel-clerks'],
            ['name' => 'create-hotel-clerks'],
            ['name' => 'edit-hotel-clerks'],
            ['name' => 'delete-hotel-clerks'],

            ['name' => 'list-travel-companies'],
            ['name' => 'create-travel-companies'],
            ['name' => 'edit-travel-companies'],
            ['name' => 'delete-travel-companies'],

            ['name' => 'list-hotel-clerks'],
            ['name' => 'create-hotel-clerks'],
            ['name' => 'edit-hotel-clerks'],
            ['name' => 'delete-hotel-clerks'],

            ['name' => 'list-reports'],
            ['name' => 'view-reports'],

            ['name' => 'list-customers'],
            ['name' => 'manage-customers'],

            ['name' => 'manage-settings'],
            ['name' => 'view-dashboard'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']]);
        }

        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdminRole->syncPermissions(Permission::all());

        $travelCompanyRole = Role::firstOrCreate(['name' => 'travel-company']);
        $travelCompanyRole->syncPermissions(['list-hotels', 'create-hotels', 'edit-hotels', 'delete-hotels', 'view-reports']);

        $hotelManagerRole = Role::firstOrCreate(['name' => 'hotel-manager']);
        $hotelManagerRole->syncPermissions(['list-rooms', 'create-rooms', 'edit-rooms', 'delete-rooms', 'view-reports', 'list-bookings']);

        $hotelClerkRole = Role::firstOrCreate(['name' => 'hotel-clerk']);
        $hotelClerkRole->syncPermissions(['list-bookings', 'create-bookings', 'edit-bookings', 'view-reports']);

        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $customerRole->syncPermissions(['list-bookings', 'create-bookings']);
    }
}
