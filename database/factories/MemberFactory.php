<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'country' => $this->faker->country,
            'category' => $this->faker->word,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'year_of_establishment' => $this->faker->date,
            'website' => $this->faker->url,
            'image' => $this->faker->imageUrl(),
            'manager_name' => $this->faker->name,
        ];
    }
}
