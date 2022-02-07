<?php

namespace Tests\Feature\Post;

use App\Domain\Post\model\Post;
use App\Domain\Post\model\Repost;
use App\Domain\User\models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use function dd;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_list_all_posts()
    {
        $user = User::factory()->create();
        Auth::setUser($user);
        $post = Post::factory()->count(1)->create();
        $repost = Repost::factory()->count(1)->create();
        $totalPosts = $post->count() + $repost->count();
        $response = $this->get('api/post');
        $response->assertStatus(200);
        $this->assertEquals($totalPosts, count($response->json()));
    }

    public function test_should_list_all_user_posts_and_reposts()
    {
        $user = User::factory()->create();
        Auth::setUser($user);
        $post = Post::factory()->count(2)->create(['user_id' => $user->id]);
        $repost = Repost::factory()->count(2)->create(['user_id' => $user->id]);
        $totalPosts = $post->count() + $repost->count();
        $response = $this->get('api/post?filter=user');
        $response->assertStatus(200);
        $this->assertEquals($totalPosts, count($response->json()));
    }
}
