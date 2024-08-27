<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JurusanFactory extends Factory
{
    // Definisikan urutan data yang ingin digunakan
    protected static $jurusanIndex = 0;
    
    // Array data jurusan yang berurutan
    protected static $jurusanData = [
        ['nama_jurusan' => 'TEKNIK SIPIL',                      'kode_jurusan' => '01'],
        ['nama_jurusan' => 'TEKNIK MESIN',                      'kode_jurusan' => '02'],
        ['nama_jurusan' => 'TEKNIK PERKAPALAN',                 'kode_jurusan' => '03'],
        ['nama_jurusan' => 'TEKNIK ELEKTRO',                    'kode_jurusan' => '04'],
        ['nama_jurusan' => 'TEKNIK ARSITEKTUR',                 'kode_jurusan' => '05'],
        ['nama_jurusan' => 'TEKNIK GEOLOGI',                    'kode_jurusan' => '06'],
        ['nama_jurusan' => 'TEKNIK INDUSTRI',                   'kode_jurusan' => '07'],
        ['nama_jurusan' => 'TEKNIK KELAUTAN',                   'kode_jurusan' => '08'],
        ['nama_jurusan' => 'TEKNIK SISTEM PERKAPALAN',          'kode_jurusan' => '09'],
        ['nama_jurusan' => 'TEKNIK PERENCANAAN WILAYAH KOTA',   'kode_jurusan' => '10'],
        ['nama_jurusan' => 'TEKNIK PERTAMBANGAN',               'kode_jurusan' => '11'],
        ['nama_jurusan' => 'TEKNIK INFORMATIKA',                'kode_jurusan' => '12'],
        ['nama_jurusan' => 'TEKNIK LINGKUNGAN',                 'kode_jurusan' => '13'],
        ['nama_jurusan' => 'TEKNIK METALURGI',                  'kode_jurusan' => '14'],
        ['nama_jurusan' => 'PROGRAM PROFESI INSINYUR',          'kode_jurusan' => '15'],
        ['nama_jurusan' => 'PROGRAM PROFESI ARSITEKTUR',        'kode_jurusan' => '16'],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Dapatkan data dari array berdasarkan index
        $data = self::$jurusanData[self::$jurusanIndex];

        // Tingkatkan index untuk data berikutnya
        self::$jurusanIndex++;

        // Jika index mencapai batas array, reset kembali ke 0 (opsional, jika ingin looping)
        if (self::$jurusanIndex >= count(self::$jurusanData)) {
            self::$jurusanIndex = 0;
        }

        return [
            'nama_jurusan' => $data['nama_jurusan'],
            'kode_jurusan' => $data['kode_jurusan'],
        ];
    }
}
