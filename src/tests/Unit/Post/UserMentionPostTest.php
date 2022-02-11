<?php

namespace Tests\Unit\Post;

use App\Domain\Post\actions\IndentifyUserMentionAction;
use App\Domain\User\models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserMentionPostTest extends TestCase
{
    use WithFaker;

    public function test_should_identify_user_when_mentioned_in_post_content()
    {
        $content = $this->faker->text(10);
        $content = $content . " {User}any_user{/User} any text {User}another_user{/User}";
        $matches = (new IndentifyUserMentionAction())->execute($content);
        $this->assertEquals([
            "any_user",
            "another_user"
        ],$matches);
    }

    public function test_shouldnt_identify_mentioned_user_in_post_content()
    {
        $content = $this->faker->text(777);
        $matches = (new IndentifyUserMentionAction())->execute($content);
        $this->assertEquals(false,$matches);
    }
}
