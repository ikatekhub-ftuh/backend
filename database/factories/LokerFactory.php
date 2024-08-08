<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loker>
 */
class LokerFactory extends Factory
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
            'tgl_selesai' => fake()->date(),
            'lokasi' => fake()->city(),
            'pengalaman_kerja' => fake()->numberBetween(1, 99),
            'perusahaan' => fake()->sentence(),
            'posisi' => fake()->sentence(),
            'role' => fake()->sentence()
        ];
    }
}
