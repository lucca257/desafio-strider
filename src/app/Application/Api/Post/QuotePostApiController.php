<?php

namespace App\Application\Api\Post;

use App\Application\Api\Post\Validators\PostApiRequestValidator;
use App\Domain\Post\model\QuotePost;
use App\Domain\User\actions\UserCantPostAction;
use App\Domain\User\Exceptions\UserExceedTotalPostsError;
use App\infra\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class   QuotePostApiController extends Controller
{
    /**
     * @param PostApiRequestValidator $request
     * @param UserCantPostAction $userCanPost
     * @return mixed
     * @throws UserExceedTotalPostsError
     */
    public function store(PostApiRequestValidator $request, UserCantPostAction $userCanPost)
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
