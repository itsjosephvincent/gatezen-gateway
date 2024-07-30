<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // users
            'view users',
            'create users',
            'update users',
            'delete users',
            // roles
            'view roles',
            'create roles',
            'update roles',
            'delete roles',
            // permissions
            'view permissions',
            'create permissions',
            'update permissions',
            'delete permissions',
            // projects
            'view projects',
            'create projects',
            'update projects',
            'delete projects',
            // wallets
            'view wallets',
            'create wallets',
            'update wallets',
            'delete wallets',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            [
                'name' => 'Super Admin',
                'project_id' => null,
            ],
            [
                'name' => 'Admin',
                'project_id' => null,
            ],
            [
                'name' => 'Manager',
                'project_id' => null,
            ],
            [
                'name' => 'Accountant',
                'project_id' => null,
            ],
            [
                'name' => 'Editor',
                'project_id' => null,
            ],
            [
                'name' => 'Partner',
                'project_id' => null,
            ],
            [
                'name' => 'Affiliate',
                'project_id' => 1,
            ],
            [
                'name' => 'Partner 200',
                'project_id' => 1,
            ],
            [
                'name' => 'Partner 400',
                'project_id' => 1,
            ],
            [
                'name' => 'Partner 500',
                'project_id' => 1,
            ],
            [
                'name' => 'Partner 600',
                'project_id' => 1,
            ],
            [
                'name' => 'Partner 800',
                'project_id' => 1,
            ],
            [
                'name' => 'Partner 1,250',
                'project_id' => 1,
            ],
            [
                'name' => 'Partner 1,800',
                'project_id' => 1,
            ],
            [
                'name' => 'Partner 2,400',
                'project_id' => 1,
            ],
            [
                'name' => 'Partner 2,500',
                'project_id' => 1,
            ],
            [
                'name' => 'Partner 5,000',
                'project_id' => 1,
            ],
            [
                'name' => 'Partner 10,000',
                'project_id' => 1,
            ],
            [
                'name' => 'Partner 15,000',
                'project_id' => 1,
            ],
            [
                'name' => 'Partner 25,000',
                'project_id' => 1,
            ],
            [
                'name' => 'Partner 50,000',
                'project_id' => 1,
            ],
            [
                'name' => 'Partner 100,000',
                'project_id' => 1,
            ],
        ];

        foreach ($roles as $role) {
            $new_role = Role::firstOrCreate([
                'name' => $role['name'],
                'project_id' => $role['project_id'],
            ]);

            if ($role == 'Super Admin' || $role == 'Admin') {
                $new_role->givePermissionTo(Permission::all());
            }
        }
    }
}
