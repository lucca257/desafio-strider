<?php

namespace Database\Factories;

use App\Domain\Post\model\Post;
use App\Domain\Post\model\QuotePost;
use App\Domain\User\models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotePostFactory extends Factory
{
    protected $model = QuotePost::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id" => User::all()->random()->id,
            "post_id" => Post::all()->random()->id,
            "content" => $this->faker->realText
        ];
    }
}
