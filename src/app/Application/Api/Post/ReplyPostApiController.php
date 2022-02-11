<?php

namespace App\Application\Api\Post;

use App\Application\Api\Post\Validators\CreateQuotePostValidator;
use App\Application\Api\Post\Validators\CreateReplyPostValidator;
use App\Application\Api\Post\Validators\PostApiRequestValidator;
use App\Domain\Post\model\QuotePost;
use App\Domain\User\actions\UserCantPostAction;
use App\Domain\User\Exceptions\UserExceedTotalPostsError;
use App\infra\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReplyPostApiController extends Controller
{
    /**
     * @param CreateReplyPostValidator $request
     * @param UserCantPostAction $userCanPost
     * @return mixed
     * @throws UserExceedTotalPostsError
     */
    public function store(CreateReplyPostValidator $request, UserCantPostAction $userCanPost)
    {
        $user = Auth::user();
        if($userCanPost->execute($user->id)){
            throw new UserExceedTotalPostsError();
        }
        return QuotePost::create([
            "user_id" => $user->id,
            ...$request->validated()
        ]);
    }
}
