<?php

namespace Database\Factories;

use App\Models\Alumni;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumniFactory extends Factory
{
    protected $model = Alumni::class;

    // Define a static index to keep track of the current user number
    protected static $userIndex = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate the name based on the current index
        $nama = 'User ' . self::$userIndex;

        // Increment the index for the next user
        self::$userIndex++;

        // Optionally, reset the index if you want to loop through User 1 to User 20 again
        if (self::$userIndex > 20) {
            self::$userIndex = 1;
        }

        return [
            'nim'           => $this->faker->regexify('[A-Z]{5}[0-8]{5}'), // NIM/Stambuk
            'nama'          => $nama, // Names from User 1 to User 20
            'tgl_lahir'     => '1990-01-01', // Same date of birth for all
            'jurusan'       => 'PROGRAM PROFESI INSINYUR', // Same Jurusan for all
            'no_telp'       => $this->faker->numerify('62##########'),
            'angkatan'      => $this->faker->numberBetween(1970, 2023),
            'kelamin'       => $this->faker->randomElement(['l', 'p']),
            'agama'         => $this->faker->randomElement([
                'Islam', 
                'Kristen Protestan', 
                'Kristen Katolik', 
                'Hindu', 
                'Buddha', 
                'Konghucu'
            ]),
            'golongan_darah' => $this->faker->randomElement([
                'A+', 
                'A-', 
                'B+', 
                'B-', 
                'O+', 
                'O-', 
                'AB+', 
                'AB-'
            ]),
            'validated' => true
        ];
    }
}
