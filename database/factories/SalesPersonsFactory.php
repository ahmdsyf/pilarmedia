<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SalesPersonsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'SalesPersonName' => $this->faker->name(),
            'Address' => $this->faker->address(),
            'ContactPerson' => $this->faker->phoneNumber(),
        ];
    }
}
