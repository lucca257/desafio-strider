<?php

namespace Tests\Feature\Post;

use App\Domain\Post\model\Post;
use App\Domain\Post\model\QuotePost;
use App\Domain\Post\model\ReplyPost;
use App\Domain\Post\model\Repost;
use App\Domain\User\models\Follows;
use App\Domain\User\models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_should_list_all_posts_reposts_and_quote_posts()
    {
        $totalPosts = 0;
        $users = User::factory()
            ->count(4)
            ->has( Post::factory()->count(2) )
            ->has( Repost::factory()->count(2) )
            ->has( QuotePost::factory()->count(1) )
            ->create();
        $users->each(function($user) use ($totalPosts) {
            $totalPosts += $user->posts_count + $user->reposts_count + $user->quote_posts_count;;
        });
        $totalPosts = $users->count() * 5;
        $response = $this->get('api/post');
        $response->assertStatus(200);
        $this->assertEquals($totalPosts, count($response->json()));
    }

    public function test_should_list_all_followed_posts()
    {
        $users = User::factory()
            ->count(4)
            ->has( Post::factory()->count(2) )
            ->has( Repost::factory()->count(2) )
            ->has( QuotePost::factory()->count(1) )
            ->create();
        $users->each(function($u) {
            Follows::factory()->create(['follower_id' => $u->id]);
        });
        $mock_user = $users->random();
        $followed_user = User::whereId($mock_user->id)->withCount(['posts', 'reposts', 'quotePosts'])->first();
        Auth::setUser($mock_user);
        $totalPosts = $followed_user->posts_count + $followed_user->reposts_count + $followed_user->quote_posts_count;
        $response = $this->get('api/post?filter=follows');
        $response->assertStatus(200);
        $this->assertEquals($totalPosts, count($response->json()));
    }

    public function test_should_list_all_user_reply_posts()
    {
        $users = User::factory()
            ->count(4)
            ->has( Post::factory()->count(3) )
            ->has( ReplyPost::factory()->count(2) )
            ->create();
        $user = User::whereId($users->random()->id)->withCount(['replyPosts'])->first();
        Auth::setUser($user);
        $response = $this->get('api/post/reply');
        $response->assertStatus(200);
        $this->assertEquals($user->reply_posts_count, count($response->json()));
    }

    public function test_shouldnt_post_content_with_more_than_777_characters(){
        Auth::setUser(User::factory()->create());
        $this->setUpFaker();
        $mock_data = [
            "content" => $this->faker->realText(989)
        ];
        $response = $this->post('api/post',$mock_data);
        $response
            ->assertStatus(422)
            ->assertJson([
                "content" => ["The content must not be greater than 777 characters."]
            ]);
    }

    public function test_shouldnt_create_post_without_content(){
        Auth::setUser(User::factory()->create());
        $this->setUpFaker();
        $response = $this->post('api/post');
        $response
            ->assertStatus(422)
            ->assertJson([
                "content" => ["The content field is required."]
            ]);
    }


    public function test_shouldnt_create_user_post(){
        Auth::setUser(User::factory()->create());
        $this->setUpFaker();
        $mock_data = [
            "content" => $this->faker->realText(775)
        ];
        $response = $this->post('api/post',$mock_data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', $mock_data);
    }
}
