<?php

namespace Tests\Feature\User;

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

class UserApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_should_list_user_profile_data()
    {
        $users = User::factory()
            ->count(20)
            ->has( Post::factory()->count(2) )
            ->has( Repost::factory()->count(2) )
            ->has( QuotePost::factory()->count(2) )
            ->has( ReplyPost::factory()->count(2) )
            ->create();
        $users->each(function($u) {
            Follows::factory()->create();
        });
        $response = $this->get("api/user/{$users->random()->id}");
        $response->assertStatus(200);
        //$this->assertDatabaseHas('users', $mock_user);
    }
}
