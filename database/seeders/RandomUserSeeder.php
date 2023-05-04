<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RandomUserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'User 1',
                'email' => 'user1@user.com',
                'password' => bcrypt('user123'),
            ],
            [
                'name' => 'User 2',
                'email' => 'user2@user.com',
                'password' => bcrypt('user123'),
            ],
        ];
        $role = Role::create(['name' => 'User']);
        $permissions = Permission::whereNotIn('name', ['user-create', 'role-create'])->pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        foreach ($users as $userData) {
            $user = User::create($userData);


            $user->assignRole([$role->id]);
        }
    }
}
