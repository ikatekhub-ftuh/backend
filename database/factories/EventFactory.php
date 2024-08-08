<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul  = $this->faker->sentence(5);
        $slug = Str::slug(Str::limit($judul, 200));

        return [
            'judul' => $judul,
            'slug' => $slug, 
            'gambar' => $slug.'.jpg',
            'konten' => fake()->paragraphs(3, true),
            'penyelenggara' => fake()->sentence(2),
            'tgl_event' => fake()->date(),
            'lokasi_event' => fake()->city(),
            'kouta' => fake()->numberBetween(1, 999),
            'peserta' => fake()->numberBetween(1, 999)
        ];
    }
}
