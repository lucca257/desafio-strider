<?php

namespace Database\Factories;

use App\Domain\User\models\Follows;
use App\Domain\User\models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowsFactory extends Factory
{
    protected $model = Follows::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all();

        return [
            "follower_id" => $this->faker->randomElement($users),
            "followered_id" => $this->faker->randomElement($users),
        ];
    }
}
