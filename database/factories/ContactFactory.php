<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Contact;
use App\Models\User;

/**
 * @extends Factory<Contact>
 */
class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'alt_phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'dob' => $this->faker->date(),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
