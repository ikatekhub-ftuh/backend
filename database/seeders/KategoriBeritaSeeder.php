<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KategoriBeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the table
        DB::table('kategori_berita')->truncate();
        
        $categories = [
            'Olahraga',
            'Pendidikan',
            'Bisnis',
            'Sains dan Teknologi',
            'Budaya dan Seni',
            'Hiburan',
            'Kesehatan',
            'Wisata',
        ];

        foreach ($categories as $category) {
            DB::table('kategori_berita')->insert([
                'kategori' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}
