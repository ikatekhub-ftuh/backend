<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class mainUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }

    public function run()
    {
        User::factory()->create([
            'email' => "user@gmail.com",
            'password' => "12345678",
            'avatar' => "gambar/dummy/gambar/test.png",
        ]);

        User::factory()->create([
            'email' => "admin@gmail.com",
            'password' => "admin123",
            'avatar' => "gambar/dummy/gambar/test.png",
            'is_admin' => 1,
        ]);
    }
}
