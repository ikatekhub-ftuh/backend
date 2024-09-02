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
            'gambar'                => 'gambar/berita/' . fake()->randomElement(["99LwWXVv1TlDUssCyMepP0AmFTMKppLIcZbCqOfs.webp", "T3D4vMqUX5xTGjeMU0yavtVYtY5K5WoJ2zBPKiVB.webp", "vF7rDFdbij4bEMsantvxVKpzgmWy99SOIe5sqvuC.webp", "VWf1W2bGzYGUvqQAt2xdK5vWwg3ddZ1Ykcrv8P4a.webp"]),
            'konten'                => fake()->paragraphs(3, true),
            'deskripsi'             => fake()->sentences(3, true),
            'total_like'            => fake()->numberBetween(0, 1000)
        ];
    }
}
