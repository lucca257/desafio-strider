<?php

namespace App\Domain\Post\actions;

use App\Domain\Post\model\QuotePost;
use App\Domain\Post\model\ReplyPost;
use App\Domain\User\models\User;

class CreateReplyPostAction
{
    /**
     * @param array $userNames
     * @param string $post_id
     * @return void
     */
    public function execute(array $userNames, string $post_id): void
    {
        $users = User::whereIn('username',$userNames)->pluck('id');
        foreach($users as $user_id){
            ReplyPost::create([
                "user_id" => $user_id,
                "post_id" => $post_id,
            ]);
        }
    }
}
