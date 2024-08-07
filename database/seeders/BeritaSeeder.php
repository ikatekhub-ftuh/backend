<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            DB::table('berita')->insert([
                'judul_berita' => 'Judul Berita ' . Str::random(5),
                'penulis' => 'Penulis ' . Str::random(5),
                'thumbnail' => 'thumbnail' . rand(1, 10) . '.jpg',
                'artikel' => $this->generateDummyArticle(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Generate a dummy article text.
     *
     * @return string
     */
    private function generateDummyArticle(): string
    {
        return Str::random(200) . ' ' . Str::random(200) . ' ' . Str::random(200);
    }
}
