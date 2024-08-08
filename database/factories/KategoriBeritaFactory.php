<?php
namespace Database\Factories;

use App\Models\KategoriBerita;
use Illuminate\Database\Eloquent\Factories\Factory;

class KategoriBeritaFactory extends Factory
{
    protected $model = KategoriBerita::class;

    public function definition(): array
    {
        $kategori = fake()->sentence();
        $slug = Str::slug($kategori);
        return [
            'kategori' => $kategori,
            'slug' => $slug,
        ];
    }
}
