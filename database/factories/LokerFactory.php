<?php

namespace Database\Factories;

use App\Models\Loker;
use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loker>
 */
class LokerFactory extends Factory
{
    protected $model = Loker::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = fake()->words(3, true);;
        $slug = Str::slug(Str::limit($judul, 200));

        return [
            // 'id_loker'          => fake()->numberBetween(1, 10),
            'id_perusahaan'     => 1,
            'judul'             => $judul,
            'slug'              => $slug, 
            // 'gambar'            => $slug.'.jpg',
            'konten'            => '<p>' . fake()->paragraphs(3, true) . '</p>',
            'deskripsi'         => fake()->sentences(3, true),
            'tgl_selesai'       => fake()->date(),
            'lokasi'            => fake()->city(),
            'pengalaman_kerja'  => fake()->numberBetween(1, 99),
            'role'              => fake()->randomElement(['Paruh Waktu', 'Purna Waktu', 'Freelance'])
        ];
    }
}
