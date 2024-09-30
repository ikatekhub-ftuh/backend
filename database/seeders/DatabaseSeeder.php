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
use App\Models\peserta_event;
use App\Models\JenjangPendidikan;
use App\Models\Jurusan;
use App\Models\StatistikPendidikan;
use Database\Factories\mainBeritaFactory;
use Database\Factories\mainLokerFactory;
use Database\Factories\mainUserFactory;
use Illuminate\Database\Seeder;
use Throwable;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ini_set('memory_limit', '1G');

        // User::factory(200)->create();
        // (new mainUserFactory())->run();
        // Perusahaan::factory(10)->create();
        // (new mainLokerFactory())->run();
        // KategoriBerita::factory(12)->create();
        // (new mainBeritaFactory())->run();
        // Berita::factory(1000)->create();
        // Alumni::factory(200)->create();
        // JenjangPendidikan::factory(200)->create();
        // try {
        //     Like::factory(100)->create();
        // } catch (\Exception $e) {
        //     // do nothing, error because of unique constraint is expected
        // }
        // Loker::factory(30)->create();
        // Event::factory(3)->create(); //kenapa nda pakai run() saja?
        // peserta_event::factory(20)->create();
        // jurusan::factory(16)->create();
        // StatistikPendidikan::factory(5)->create();
    }
}
