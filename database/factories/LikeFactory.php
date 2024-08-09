<?php
namespace Database\Factories;

use App\Models\Like;
use App\Models\Berita;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    protected $model = Like::class;

    public function definition(): array
    {
        $id_berita = fake()->numberBetween(10, Berita::count());
        $id_user = fake()->numberBetween(1, User::count());

        while ($id_berita === $id_user) {
            $id_user = fake()->numberBetween(1, User::count());
        }

        return [
            'id_berita' => $id_berita,
            'id_user'   => $id_user,
        ];
    }
}
