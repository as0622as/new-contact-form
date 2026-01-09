<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name'  => $this->faker->lastName(),
            'last_name'   => $this->faker->firstName(),
            'gender'      => $this->faker->randomElement([1, 2]),
            'email'       => $this->faker->safeEmail(),
            'tel'         => $this->faker->numerify('#####'),
            'address'     => $this->faker->address(),
            'building'    => $this->faker->optional()->secondaryAddress(),
            'category_id' => $this->faker->numberBetween(1, 5),
            'content'     => $this->faker->realText(100),
        ];
    }
}
