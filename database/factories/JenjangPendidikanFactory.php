<?php

namespace Database\Factories;

use App\Models\Alumni;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JenjangPendidikan>
 */
class JenjangPendidikanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_alumni' => fake()->numberBetween(1, Alumni::count()),
            'jurusan'   => 'PROGRAM PROFESI INSINYUR', // Same Jurusan for all
            'angkatan'  => $this->faker->numberBetween(1970, 2023),
            'nim'       => $this->faker->regexify('[A-Z]{5}[0-8]{5}'), // NIM/Stambuk
            'jenjang'   => fake()->randomElement(['S1', 'S2', 'S3', 'PPI', 'PPA']),
            'nim'       => fake()->randomElement(['D011', 'D012', 'D021', 'D022', 'D061', 'D064']) . fake()->numberBetween(12, 22) . fake()->randomNumber(3, true)
        ];
    }
}
