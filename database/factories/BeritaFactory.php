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
        // fake a good title
        $judul = fake()->sentence(5);
        $slug = Str::slug(Str::limit($judul, 200));

        return [
            'id_kategori_berita'    => fake()->numberBetween(1, KategoriBerita::count()),
            'judul'                 => $judul,
            'slug'                  => $slug,
            'penulis'               => fake()->name(),
            // 'gambar'                => 'berita/img.jpg',
            'gambar' => "/gambar/dummy/images/test.png",
            'konten'                => fake()->paragraphs(50, true), 
            'total_like'            => fake()->numberBetween(0, 1000)
        ];
    }
}
