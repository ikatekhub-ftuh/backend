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
        $jurusan = ['informatika', 'teknik mesin'];
        $kelamin = ['l', 'p'];
        $golonganDarah = ['a', 'o', 'b', 'ab'];

        for ($i = 0; $i < 50; $i++) {
            DB::table('alumni')->insert([
                'nama' => 'Nama ' . Str::random(5),
                'tgl_lahir' => now()->subYears(rand(18, 50))->format('Y-m-d'),
                'stambuk' => 'STB-' . Str::random(8),
                'jurusan' => $jurusan[array_rand($jurusan)],
                'angkatan' => rand(1980, 2024),
                'kelamin' => $kelamin[array_rand($kelamin)],
                'golongan_darah' => $golonganDarah[array_rand($golonganDarah)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
