<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StatistikPendidikan>
 */
class StatistikPendidikanFactory extends Factory
{
    // Definisikan urutan data yang ingin digunakan
    protected static $statistikIndex = 0;
    
    // Array data jurusan yang berurutan
    protected static $dataStatistik = [
        ['jenjang' => 'S1',         'jumlah' => '20324'],
        ['jenjang' => 'S2',         'jumlah' => '4014'],
        ['jenjang' => 'S3',         'jumlah' => '54'],
        ['jenjang' => 'PPI',        'jumlah' => '32'],
        ['jenjang' => 'PPA',        'jumlah' => '23'],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Dapatkan data dari array berdasarkan index
        $data = self::$dataStatistik[self::$statistikIndex];

        // Tingkatkan index untuk data berikutnya
        self::$statistikIndex++;

        // Jika index mencapai batas array, reset kembali ke 0 (opsional, jika ingin looping)
        if (self::$statistikIndex >= count(self::$dataStatistik)) {
            self::$statistikIndex = 0;
        }

        return [
            'jenjang'   => $data['jenjang'],
            'jumlah'    => $data['jumlah'],
        ];
    }
}
