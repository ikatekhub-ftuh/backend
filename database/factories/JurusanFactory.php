<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JurusanFactory extends Factory
{
    // Definisikan urutan data yang ingin digunakan
    protected static $jurusanIndex = 0;
    
    // Array data jurusan yang berurutan
    protected static $jurusanData = [
        ['nama_jurusan' => 'TEKNIK SIPIL',                      'kode_jurusan' => 'D01'],
        ['nama_jurusan' => 'TEKNIK MESIN',                      'kode_jurusan' => 'D02'],
        ['nama_jurusan' => 'TEKNIK PERKAPALAN',                 'kode_jurusan' => 'D03'],
        ['nama_jurusan' => 'TEKNIK ELEKTRO',                    'kode_jurusan' => 'D04'],
        ['nama_jurusan' => 'TEKNIK ARSITEKTUR',                 'kode_jurusan' => 'D05'],
        ['nama_jurusan' => 'TEKNIK GEOLOGI',                    'kode_jurusan' => 'D06'],
        ['nama_jurusan' => 'TEKNIK INDUSTRI',                   'kode_jurusan' => 'D07'],
        ['nama_jurusan' => 'TEKNIK KELAUTAN',                   'kode_jurusan' => 'D08'],
        ['nama_jurusan' => 'TEKNIK SISTEM PERKAPALAN',          'kode_jurusan' => 'D09'],
        ['nama_jurusan' => 'TEKNIK PERENCANAAN WILAYAH KOTA',   'kode_jurusan' => 'D10'],
        ['nama_jurusan' => 'TEKNIK PERTAMBANGAN',               'kode_jurusan' => 'D11'],
        ['nama_jurusan' => 'TEKNIK INFORMATIKA',                'kode_jurusan' => 'D12'],
        ['nama_jurusan' => 'TEKNIK LINGKUNGAN',                 'kode_jurusan' => 'D13'],
        ['nama_jurusan' => 'PPI',                               'kode_jurusan' => 'D064'],
        ['nama_jurusan' => 'PPA',                               'kode_jurusan' => 'D064'],
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
