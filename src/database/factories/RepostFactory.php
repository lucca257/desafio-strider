<?php

namespace Database\Factories;

use App\Domain\Post\model\Post;
use App\Domain\Post\model\Repost;
use App\Domain\User\models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepostFactory extends Factory
{
    protected $model = Repost::class;
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
            "post_id" => Post::all()->random()->id,
            "content" => $this->faker->realText
        ];
    }
}
