<?php
namespace Database\Factories;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BeritaFactory extends Factory
{
    protected $model = Berita::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul  = $this->faker->sentence(10);
        $slug = Str::slug(Str::limit($judul, 200));

        return [
            'id_kategori_berita'    => fake()->numberBetween(1, KategoriBerita::count()),
            'judul'                 => Str::limit($judul, 255),
            'slug'                  => $slug,
            'penulis'               => fake()->name(),
            'gambar'                => 'berita/img.jpg',
            'konten'                => fake()->paragraphs(3, true), 
            'total_like'            => fake()->numberBetween(0, 1000)
        ];
    }
}
