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
        return [
            'id_berita' => Berita::factory(),
            'id_user' => User::factory(), 
        ];
    }
}
