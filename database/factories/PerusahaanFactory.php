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
        $nama = fake()->words(3, true) . (fake()->boolean() ? ' PT' : ' LTD');
        return [
            'nama_perusahaan'   => $nama,
            // 'logo'              => $nama .'.jpg',
            'logo' => "gambar/dummy/images/test.png",
        ];
    }
}
