<?php
namespace Database\Factories;

use App\Models\KategoriBerita;
use Illuminate\Database\Eloquent\Factories\Factory;

class KategoriBeritaFactory extends Factory
{
    protected $model = KategoriBerita::class;

    public function definition(): array
    {
        return [
            'kategori' => $this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
