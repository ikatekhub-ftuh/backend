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
        //  User::factory()->create([
        //     'fullname' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // User::factory(5)->create();
        // KategoriBerita::factory(4)->create();
        // Perusahaan::factory(4)->create();
        // Berita::factory(20)->create(); 
        Like::factory(50)->create();
        // Loker::factory(22)->create();
        // Event::factory(20)->create();
        // Alumni::factory(20)->create();
    }
}
