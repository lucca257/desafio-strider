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

class QuotePostApiTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function test_content_field_is_required_on_create_quote_post(){
        $users = User::factory()
            ->count(2)
            ->create();
        $post = Post::factory()->create([
            "user_id" => $users->first()->id
        ]);
        Auth::setUser($users->last());
        $mock_data = [
            "post_id" => $post->id
        ];
        $response = $this->post('api/quotepost',$mock_data);
        $response
            ->assertStatus(422)
            ->assertJson([
                "content" => ["The content field is required."]
            ]);
    }

    public function test_should_not_quote_post_content_greater_than_777_characters(){
        $users = User::factory()
            ->count(2)
            ->create();
        $post = Post::factory()->create([
            "user_id" => $users->first()->id
        ]);
        Auth::setUser($users->last());
        $mock_data = [
            "content" => $this->faker->realText(999),
            "post_id" => $post->id
        ];
        $response = $this->post('api/quotepost',$mock_data);
        $response
            ->assertStatus(422)
            ->assertJson([
                "content" => ["The content must not be greater than 777 characters."]
            ]);
    }

    public function test_post_id_field_is_required_on_create_quote_post()
    {
        $users = User::factory()
            ->count(2)
            ->create();
        $post = Post::factory()->create([
            "user_id" => $users->first()->id
        ]);
        Auth::setUser($users->last());
        $mock_data = [
            "content" => $this->faker->realText(770),
        ];
        $response = $this->post('api/quotepost',$mock_data);
        $response
            ->assertStatus(422)
            ->assertJson([
                "post_id" => ["The post id field is required."]
            ]);
    }

    public function test_post_id_field_should_be_valid_on_create_quote_post()
    {
        $users = User::factory()
            ->count(2)
            ->create();
        $post = Post::factory()->create([
            "user_id" => $users->first()->id
        ]);
        Auth::setUser($users->last());
        $mock_data = [
            "content" => $this->faker->realText(770),
            "post_id" => "any_post_id"
        ];
        $response = $this->post('api/quotepost',$mock_data);
        $response
            ->assertStatus(422)
            ->assertJson([
                "post_id" => ["The selected post id is invalid."]
            ]);
    }

    public function test_should_not_create_quote_post_when_have_more_than_five_posts_in_a_day(){
        $users = User::factory()->count(2)
            ->has( Post::factory()->count(2) )
            ->has( Repost::factory()->count(2) )
            ->has( QuotePost::factory()->count(1) )
            ->create();
        Auth::setUser($users->last());
        $post = Post::factory()->create([
            "user_id" => $users->first()->id
        ]);
        $mock_data = [
            "post_id" => $post->id
        ];
        $response = $this->post('api/repost',$mock_data);
        $response
            ->assertStatus(422)
            ->assertJson([
                "message" => "Whoops, did you exceed the total posts. You can post only 5 posts in a day."
            ]);
    }
}
