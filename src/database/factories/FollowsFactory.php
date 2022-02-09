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
//        $seletec_user = $this->faker->randomElement($users);
//        $follows = Follows::whereNotIn('followered_id')->pluck('follower_id');
//        $users = User::whereNotIn('id', $follows)->pluck('id')->toArray();
//        $sorted_user = $this->faker->randomElement($users);
 //       unset($users[array_search($sorted_user, $users)]);

        return [
            "follower_id" => $this->faker->randomElement($users),
            "followered_id" => $this->faker->unique()->randomElement($users),
        ];
    }
}
