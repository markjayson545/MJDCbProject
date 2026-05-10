<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
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
            'contactno' => fake()->optional()->phoneNumber(),
            'email' => fake()->optional()->safeEmail(),
            'department' => fake()->optional()->word(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
