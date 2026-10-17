<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kontak>
 */
class KontakFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unit' => fake()->randomElement(['PSB', 'Kesantrian', 'Akademik', 'Keuangan']),
            'nama' => fake()->name(),
            'jabatan' => fake()->jobTitle(),
            'telepon' => '08'.fake()->numerify('##########'),
            'whatsapp' => '08'.fake()->numerify('##########'),
            'email' => fake()->safeEmail(),
            'alamat' => fake()->address(),
            'urutan' => fake()->numberBetween(0, 20),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the contact is inactive.
     */
    public function nonaktif(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
