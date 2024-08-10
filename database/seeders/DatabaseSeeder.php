<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Loker;
use App\Models\Berita;
use App\Models\Perusahaan;
use App\Models\Like;
use App\Models\KategoriBerita;
use App\Models\Alumni;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ini_set('memory_limit', '1G');

        // User::factory(3000)->create();
        // KategoriBerita::factory(12)->create();
        Berita::factory(500)->create(); 
        // Perusahaan::factory(20)->create();
        // Loker::factory(30)->create();
        // Event::factory(5)->create();

        // sometimes error, paksami saja
        // Like::factory(400)->create();

        // kalau mau run banyak data, uncomment ini, comment yang lain
        // Alumni::factory(24000)->create();
    }
}
