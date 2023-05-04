<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Member;
use App\Models\MemberProjects;
use App\Models\News;
use App\Models\Project;
use App\Models\Publication;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(RandomUserSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(CountrySeeder::class);
        Contact::factory(20)->create();
    }
}
