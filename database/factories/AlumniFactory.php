<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Alumni;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alumni>
 */
class AlumniFactory extends Factory
{
    protected $model = Alumni::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nim'           => fake()->regexify('[A-Z]{5}[0-4]{3}'),
            'nama'          => fake()->name(),
            'tgl_lahir'     => fake()->date(),
            'jurusan'       => 'Teknik '.fake()->randomElement([
                'Perkapalan',
                'Informatika',
                'Mesin',
            ]),
            'no_telp'       => fake()->randomElement([null, fake()->unique()->phoneNumber()]),
            'angkatan'      => fake()->numberBetween(1970, 2023),
            'kelamin'       => fake()->randomElement(['l', 'p']),
            'agama'         => fake()->randomElement([
                'Islam', 
                'Kristen Protestan', 
                'Kristen Katolik', 
                'Hindu', 
                'Buddha', 
                'Konghucu'
            ]),
            'golongan_darah' => fake()->randomElement([
                'A+', 
                'A-', 
                'B+', 
                'B-', 
                'O+', 
                'O-', 
                'AB+', 
                'AB-'
            ]),
            'validated' => 0
        ];
    }
}
