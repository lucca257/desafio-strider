<?php

namespace App\Application\Api\Post;

use App\Domain\Post\model\Post;
use App\Domain\Post\model\ReplyPost;
use App\Domain\Post\model\Repost;
use App\Domain\Post\repository\PostRepository;
use App\Domain\User\actions\UserCantPostAction;
use App\Domain\User\Exceptions\UserExceedTotalPostsError;
use App\Domain\User\models\Follows;
use App\infra\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
