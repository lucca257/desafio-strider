<?php

namespace Tests\Unit\Post;

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
use function dd;

class PostTest extends TestCase
{
    use RefreshDatabase;

    use WithFaker;

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
}
