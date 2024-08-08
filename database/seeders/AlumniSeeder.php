<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AlumniSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $jurusan = ['Teknik Informatika', 'Teknik Mesin'];
        $kelamin = ['l', 'p'];
        $golonganDarah = [
                'A+', 
                'A-', 
                'B+', 
                'B-', 
                'O+', 
                'O-', 
                'AB+', 
                'AB-'
            ];
        $agama = [
            'Islam', 
            'Kristen Protestan', 
            'Kristen Katolik', 
            'Hindu', 
            'Buddha', 
            'Konghucu'
        ];

        for ($i = 0; $i < 50; $i++) {
            DB::table('alumni')->insert([
                'nim'       => 'STB-' . Str::random(8),
                'nama'      => 'Nama ' . Str::random(5),
                'tgl_lahir' => now()->subYears(rand(18, 50))->format('Y-m-d'),
                'jurusan'   => $jurusan[array_rand($jurusan)],
                'angkatan'  => rand(1980, 2024),
                'kelamin'   => $kelamin[array_rand($kelamin)],
                'agama'     => $kelamin[array_rand($kelamin)],
                'golongan_darah'    => $golonganDarah[array_rand($golonganDarah)],
                'validated' => false,
            ]);
        }
    }
}
