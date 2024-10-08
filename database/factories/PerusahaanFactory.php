<?php

namespace Database\Factories;

use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Perusahaan>
 */
class PerusahaanFactory extends Factory
{
    protected $model = Perusahaan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_perusahaan'   => fake()->randomElement(['FAKULTAS TEKNIK UNHAS']),
            'logo'              => "gambar/loker/logo-perusahaan.png",
            // 'logo'              => $nama .'.jpg',
        ];
    }
}
