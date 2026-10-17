<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Berita>
 */
class BeritaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = 'Berita '.fake()->unique()->sentence(4);

        return [
            'judul' => $judul,
            'slug' => Str::slug($judul),
            'kategori' => fake()->randomElement(['Pengumuman', 'Kegiatan', 'Prestasi']),
            'ringkasan' => fake()->paragraph(),
            'isi' => fake()->paragraphs(3, true),
            'gambar' => null,
            'penulis' => fake()->name(),
            'status' => 'draft',
            'published_at' => null,
            'is_featured' => false,
        ];
    }

    /**
     * Indicate that the news item is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }
}
