<?php

namespace Database\Factories;

use App\Models\Like;
use App\Models\Berita;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Validator;

class LikeFactory extends Factory
{
    protected $model = Like::class;

    public function definition(): array
    {
        // it works, don't touch it.
        do {
            $id_berita = fake()->numberBetween(1, Berita::count());
            $id_user = fake()->numberBetween(1, User::count());

            $validator = Validator::make(
                ['id_berita' => $id_berita, 'id_user' => $id_user],
                ['id_berita' => 'unique:likes,id_berita,NULL,id,id_user,' . $id_user]
            );
        } while ($validator->fails());

        return [
            'id_berita' => $id_berita,
            'id_user'   => $id_user,
        ];
    }
}
