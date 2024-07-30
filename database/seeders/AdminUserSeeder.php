<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_array = [
            [
                'firstname' => 'Superadmin',
                'lastname' => 'CC7',
                'email' => 'mail@thegateindex.com',
                'password' => 'CC7Gateway$',
                'role' => 'Super Admin',
                'language_id' => 1,
            ],
            [
                'firstname' => 'Admin',
                'lastname' => 'CC7',
                'email' => 'admin@thegateindex.com',
                'password' => 'CC7Gateway$',
                'role' => 'Admin',
                'language_id' => 1,
            ],
            [
                'firstname' => 'Corporate',
                'lastname' => 'CC7',
                'email' => 'corporate@thegateindex.com',
                'password' => 'CC7Gateway$',
                'role' => 'Admin',
                'language_id' => 1,
            ],
        ];

        foreach ($user_array as $user_data) {
            $user = User::firstOrCreate(
                [
                    'email' => $user_data['email'],
                ],
                [
                    'firstname' => $user_data['firstname'],
                    'lastname' => $user_data['lastname'],
                    'password' => $user_data['password'],
                    'language_id' => $user_data['language_id'],
                ]
            );

            if ($role = Role::where('name', $user_data['role'])->first()) {
                $user->assignRole($role);
            }
            $user->givePermissionTo('view permissions');
        }
    }
}
