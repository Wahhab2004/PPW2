<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name, // Nama lengkap acak
            'phone_number' => $this->faker->unique()->phoneNumber, // Nomor telepon unik
            'email' => $this->faker->unique()->safeEmail, // Email unik
            'address' => $this->faker->address, // Alamat acak
        ];
    }
}
