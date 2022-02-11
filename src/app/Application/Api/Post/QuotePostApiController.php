<?php

namespace App\Application\Api\Post;

use App\Application\Api\Post\Validators\CreateQuotePostValidator;
use App\Application\Api\Post\Validators\PostApiRequestValidator;
use App\Domain\Post\actions\CreateReplyPostAction;
use App\Domain\Post\actions\IndentifyUserMentionAction;
use App\Domain\Post\model\QuotePost;
use App\Domain\Post\model\ReplyPost;
use App\Domain\User\actions\UserCantPostAction;
use App\Domain\User\Exceptions\UserExceedTotalPostsError;
use App\Domain\User\models\User;
use App\infra\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QuotePostApiController extends Controller
{
    /**
     * @param CreateQuotePostValidator $request
     * @param UserCantPostAction $userCanPost
     * @return mixed
     * @throws UserExceedTotalPostsError
     */
    public function store(CreateQuotePostValidator $request, UserCantPostAction $userCanPost, IndentifyUserMentionAction $indentifyUserMentionAction, CreateReplyPostAction $createQuotePostAction)
    {
        $user = Auth::user();
        if($userCanPost->execute($user->id)){
            throw new UserExceedTotalPostsError();
        }
        $metion_users = $indentifyUserMentionAction->execute($request->validated('content'));
        if($metion_users){
            $createQuotePostAction->execute($metion_users, $request->validated('post_id'));
        }
        return QuotePost::create([
            "user_id" => $user->id,
            ...$request->validated()
        ]);
    }
}
