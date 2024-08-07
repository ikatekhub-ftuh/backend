<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Berita;
use App\Models\Like;
use App\Models\KategoriBerita;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        KategoriBerita::factory(5)->create();
        Berita::factory(20)->create();
        Like::factory(50)->create();
    }
}
