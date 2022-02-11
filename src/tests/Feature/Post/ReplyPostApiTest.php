<?php

namespace Tests\Feature\Post;

use App\Domain\Post\actions\IndentifyUserMentionAction;
use App\Domain\Post\model\Post;
use App\Domain\Post\model\QuotePost;
use App\Domain\Post\model\Repost;
use App\Domain\User\models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ReplyPostApiTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function test_should_create_reply_post_when_user_was_mentioned_in_post_content(){
        $mention_user = User::factory()->create(["username" => 'mention_user']);
        $user = User::factory()->create(["username" => 'any_user']);
        $post = Post::factory()->create(["user_id" => $user->id]);
        Auth::setUser($user);
        $mock_data = [
            "post_id" => $post->id,
            "content" => $this->faker->realText(700) . " {User}mention_user{/User}",
        ];
        $response = $this->post('api/quotepost',$mock_data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('reply_posts', [
            "user_id" => $mention_user->id,
            "post_id" => $post->id
        ]);
    }
}
