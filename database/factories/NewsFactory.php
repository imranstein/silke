<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'content' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(),
        ];
    }
}
