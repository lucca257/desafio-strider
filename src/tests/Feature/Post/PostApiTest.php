<?php

namespace Tests\Feature\Post;

use App\Domain\Post\model\Post;
use App\Domain\Post\model\QuotePost;
use App\Domain\Post\model\Repost;
use App\Domain\User\models\Follows;
use App\Domain\User\models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use function dd;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_list_all_posts_reposts_and_quote_posts()
    {
        $users = User::factory()
            ->count(4)
            ->has( Post::factory()->count(2) )
            ->has( Repost::factory()->count(2) )
            ->has( QuotePost::factory()->count(1) )
            ->create();
        $totalPosts = $users->count() * 5;
        $response = $this->get('api/post');
        $response->assertStatus(200);
        $this->assertEquals($totalPosts, count($response->json()));
    }
}
