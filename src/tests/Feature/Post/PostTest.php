<?php

namespace Tests\Feature\Post;

use App\Domain\Post\model\Post;
use App\Domain\User\models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use function dd;

class PostTest extends TestCase
{
    use RefreshDatabase;
    public function test_should_list_all_user_posts()
    {
        $user = User::factory()->create();
        Auth::setUser($user);
        $post = Post::factory()->count(3)->create();
        $response = $this->get('api/post');
        $response->assertStatus(200);
        $this->assertEquals($post->toArray(), $response->json());
    }
}
