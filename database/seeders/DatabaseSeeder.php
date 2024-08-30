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
        // ini_set('memory_limit', '1G');

        // User::factory()->create([
        //     'email' => "user@gmail.com",
        //     'password' => "12345678",
        //     'avatar' => "gambar/dummy/images/test.png",
        //     'is_banned' => 0,
        // ]);

        // User::factory()->create([
        //     'email' => "admin@gmail.com",
        //     'password' => "admin123",
        //     'avatar' => "gambar/dummy/images/test.png",
        // ]);

        Loker::factory()->create([
            'id_perusahaan'     => 1,
            'judul'             => 'Admin Pengelola Data Alumni ANTEK HUB',
            'slug'              => 'admin-pengelola-data-alumni-antek-hub',
            'konten'            => 'Mengelola database alumni untuk memastikan informasi selalu up-to-date.<br>Memastikan validitas dan integritas data yang masuk ke dalam sistem.<br>Mengkoordinasikan kegiatan dan acara terkait alumni dengan departemen terkait.<br>Menghasilkan laporan berkala mengenai status dan statistik alumni.<br>Berkomunikasi dengan alumni melalui berbagai saluran untuk keperluan administrasi.',
            'tgl_selesai'       => '2024-10-01',
            'lokasi'            => 'Makassar',
            'pengalaman_kerja'  => 2,
            'role'              => 'Purna Waktu'
        ]);

        Loker::factory()->create([
            'id_perusahaan'     => 1,
            'judul'             => 'Staf Administrasi dan Pengelola Data Mahasiswa',
            'slug'              => 'staf-administrasi-pengelola-data-mahasiswa',
            'konten'            => 'Mengelola data mahasiswa termasuk pendaftaran, absensi, dan nilai.<br>Membantu dalam penyusunan jadwal kuliah dan kegiatan akademik lainnya.<br>Menyusun dan mengarsipkan dokumen administratif terkait mahasiswa.<br>Bekerjasama dengan bagian akademik untuk pengelolaan database.<br>Menyiapkan laporan data mahasiswa untuk kepentingan internal dan eksternal.',
            'tgl_selesai'       => '2024-09-25',
            'lokasi'            => 'Makassar',
            'pengalaman_kerja'  => 1,
            'role'              => 'Purna Waktu'
        ]);

        Loker::factory()->create([
            'id_perusahaan'     => 1,
            'judul'             => 'Admin Sistem Informasi dan Data Pegawai',
            'slug'              => 'admin-sistem-informasi-data-pegawai',
            'konten'            => 'Mengelola data pegawai dalam sistem informasi perusahaan.<br>Memonitor dan memperbarui informasi terkait kehadiran, cuti, dan performa pegawai.<br>Membantu dalam penyusunan laporan HR untuk manajemen.<br>Menyediakan dukungan administrasi terkait pengelolaan sistem informasi SDM.<br>Memastikan data pegawai tersimpan dengan aman dan rahasia.',
            'tgl_selesai'       => '2024-10-10',
            'lokasi'            => 'Makassar',
            'pengalaman_kerja'  => 3,
            'role'              => 'Purna Waktu'
        ]);

        // User::factory(100)->create();
        // JenjangPendidikan::factory(200)->create();
        // KategoriBerita::factory(12)->create();
        // Berita::factory(100)->create();
        // Perusahaan::factory(1)->create();
        // Loker::factory(30)->create();
        // Event::factory(3)->create();
        // peserta_event::factory(20)->create();
        // jurusan::factory(16)->create();
        // StatistikPendidikan::factory(5)->create();

        // sometimes error, paksami saja
        // Like::factory(400)->create();

        // kalau mau run banyak data, uncomment ini, comment yang lain
        // Alumni::factory(20)->create();
    }
}
