<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Loker;
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
        Berita::factory(20)->create();
        // KategoriBerita::factory(2)->create();
        // Like::factory(50)->create();
        // Loker::factory(20)->create();
        // Event::factory(20)->create();
    }
}
