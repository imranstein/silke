<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(),
            'document' => $this->faker->url,
        ];
    }
}
