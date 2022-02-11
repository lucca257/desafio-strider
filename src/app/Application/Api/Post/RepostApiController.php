<?php

namespace App\Application\Api\Post;

use App\Application\Api\Post\Validators\CreateRepostValidator;
use App\Domain\Post\model\Repost;
use App\Domain\User\actions\UserCantPostAction;
use App\Domain\User\Exceptions\UserExceedTotalPostsError;
use App\infra\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RepostApiController extends Controller
{
    /**
     * @param CreateRepostValidator $request
     * @param UserCantPostAction $userCanPost
     * @return mixed
     * @throws UserExceedTotalPostsError
     */
    public function store(CreateRepostValidator $request, UserCantPostAction $userCanPost): mixed
    {
        $user = Auth::user();
        if($userCanPost->execute($user->id)){
            throw new UserExceedTotalPostsError();
        }
        return Repost::create([
            "user_id" => $user->id,
            ...$request->validated()
        ]);
    }
}
