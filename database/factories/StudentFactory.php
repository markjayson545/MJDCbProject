<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fname' => fake()->firstName(),
            'mname' => fake()->optional()->firstName(),
            'lname' => fake()->lastName(),
            'contactno' => fake()->numerify('09#########'),
            'email' => fake()->unique()->safeEmail(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
