<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\MemberProjects;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<MemberProjects>
 */
class MemberProjectsFactory extends Factory
{
    protected $model = MemberProjects::class;

    public function definition()
    {
        return [
            'member_id' => Member::select('id')->inRandomOrder()->first(),
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(),
            'document' => $this->faker->url,
        ];
    }
}
