<?php
namespace Database\Factories;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
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
        $kataKunci = ['Pemuda', 'Demo', 'Korupsi', 'Banjir', 'Jakarta', 'Indonesia', 'Presiden', 'Makassar', 'Alumni', 'Mahasiswa', 'yang', 'tidak', 'di', 'menjadi'];
        $judul  = fake()->randomElement($kataKunci) . ' ' . fake()->randomElement($kataKunci) . ' ' . fake()->randomElement($kataKunci);
        $konten = fake()->randomElement($kataKunci) . ' ' . fake()->randomElement($kataKunci) . ' ' . fake()->randomElement($kataKunci)  . ' ' . fake()->randomElement($kataKunci) . ' ' . fake()->randomElement($kataKunci)  . ' ' . fake()->randomElement($kataKunci) . ' ' . fake()->randomElement($kataKunci)  . ' ' . fake()->randomElement($kataKunci) . ' ' . fake()->randomElement($kataKunci)  . ' ' . fake()->randomElement($kataKunci) . ' ' . fake()->randomElement($kataKunci)  . ' ' . fake()->randomElement($kataKunci) . ' ' . fake()->randomElement($kataKunci)  . ' ' . fake()->randomElement($kataKunci) . ' ' . fake()->randomElement($kataKunci)  . ' ' . fake()->randomElement($kataKunci) . ' ' . fake()->randomElement($kataKunci)  . ' ' . fake()->randomElement($kataKunci) . ' ' . fake()->randomElement($kataKunci)  . ' ' . fake()->randomElement($kataKunci) . ' ' . fake()->randomElement($kataKunci) ;

        $slug = Str::slug($judul);

        return [
            'id_kategori' => KategoriBerita::factory(),
            'judul' => $judul,
            'slug' => $slug,
            'gambar' => $slug . '.jpg',
            'konten' => $konten,
            'total_like' => fake()->numberBetween(0, 1000),
        ];
    }
}
