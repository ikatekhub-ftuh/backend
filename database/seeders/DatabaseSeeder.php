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
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ini_set('memory_limit', '1G');

        // User::factory()->create([
        //     'email' => "user@gmail.com",
        //     'password' => "12345678",
        //     'avatar' => "/gambar/dummy/images/test.png",
        //     'is_banned' => 0,
        // ]);
        // User::factory()->create([
        //     'email' => "admin@gmail.com",
        //     'password' => "admin123",
        //     'avatar' => "/gambar/dummy/images/test.png",
        //     'is_banned' => 0,
        // ]);

        // User::factory(100)->create();
        // JenjangPendidikan::factory(200)->create();
        // KategoriBerita::factory(12)->create();
        Berita::factory(100)->create();
        // Perusahaan::factory(20)->create();
        // Loker::factory(30)->create();
        // Event::factory(3)->create();
        // peserta_event::factory(20)->create();
        // jurusan::factory(15)->create();
        // StatistikPendidikan::factory(5)->create();

        // sometimes error, paksami saja
        // Like::factory(400)->create();

        // kalau mau run banyak data, uncomment ini, comment yang lain
        // Alumni::factory(100)->create();
    }
}
