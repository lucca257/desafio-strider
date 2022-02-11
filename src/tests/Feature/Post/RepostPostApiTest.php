<?php

namespace Tests\Unit\Post;

use App\Domain\Post\actions\IndentifyUserMentionAction;
use App\Domain\Post\model\Post;
use App\Domain\User\models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RepostApiTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function test_content_field_is_required_on_create_repost(){
        $users = User::factory()
            ->count(2)
            ->create();
        $post = Post::factory()->create([
            "user_id" => $users->first()->id
        ]);
        Auth::setUser($users->last());
        $mock_data = [
            //"content" => $this->faker->realText(775),
            "post_id" => $post->id
        ];
        $response = $this->post('api/repost',$mock_data);
        $response
            ->assertStatus(422)
            ->assertJson([
                "content" => ["The content field is required."]
            ]);
    }
}
