<?php

namespace Database\Factories;

use App\Models\KategoriBerita;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

class KategoriBeritaFactory extends Factory
{
    protected $model = KategoriBerita::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('id_ID'); // Set locale to Indonesian

        return [
            'kategori' => $faker->word,
            'slug' => $faker->unique()->slug,
        ];
    }
}
