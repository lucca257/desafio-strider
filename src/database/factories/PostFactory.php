<?php

namespace Database\Factories;

use App\Domain\Post\model\Post;
use App\Domain\User\models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "id" => $this->faker->uuid,
            "user_id" => User::all()->random()->id,
            "content" => $this->faker->realText
        ];
    }
}
