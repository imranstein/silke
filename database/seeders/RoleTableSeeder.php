<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Editor',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role, 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()]);
        }
    }
}
