<?php

namespace Database\Factories;

use App\Models\KategoriBerita;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class KategoriBeritaFactory extends Factory
{
    protected $model = KategoriBerita::class;

    public function definition(): array
    {
        $kategori = fake()->words(2, true);

        $slug = Str::slug($kategori);
        return [
            'kategori' => $kategori,
            'slug' => $slug,
        ];
    }
}
