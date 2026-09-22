<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'movie_id' => Movie::factory(),
            'name' => fake()->sentence(3),
            'body' => fake()->paragraph(),
            'rating' => fake()->numberBetween(1, 5),
            'private' => false,
        ];
    }
}
