<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\peserta_event>
 */
class peserta_eventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_event' => $this->faker->numberBetween(1, Event::count()),
            'id_user' => $this->faker->unique()->numberBetween(1, User::count()),
        ];
    }
}
