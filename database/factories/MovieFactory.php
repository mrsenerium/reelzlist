<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->name,
            'overview' => $this->faker->text,
            'release_date' => $this->faker->date,
        ];
    }
}
