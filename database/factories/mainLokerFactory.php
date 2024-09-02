<?php

namespace Database\Factories;

use App\Models\Loker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class mainLokerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function run()
    {
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
    }
}
