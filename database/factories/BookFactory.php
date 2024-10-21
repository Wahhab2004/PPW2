<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Publisher;

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
            'title' => $this->faker->sentence,
            'writer' => $this->faker->name,
            'publisher_id' => Publisher::inRandomOrder()->first()->id, // Relasi belongsTo ke Publisher
            'publication_year' => $this->faker->numberBetween(1990, 2024), // Rentang tahun dari 1990 sampai 2024
            'number_of_pages' => $this->faker->numberBetween(100, 1000),
            'price' => $this->faker->numberBetween(50000, 500000),
            'description' => $this->faker->paragraph,
        ];
    }
}
