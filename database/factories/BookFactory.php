<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => str_replace('.', '', $this->faker->sentence(3)),
            'isbn' => $this->faker->isbn13(),
            'value' => $this->faker->randomFloat(2, 10, 999),
        ];
    }

    public function isbn10(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'isbn' => $this->faker->isbn10(),
            ];
        });
    }
}
