<?php

namespace App\Application\Api\Post;

use App\Application\Api\Post\Validators\PostApiRequestValidator;
use App\Domain\Post\model\Post;
use App\Domain\Post\model\QuotePost;
use App\Domain\Post\model\ReplyPost;
use App\Domain\Post\repository\PostRepository;
use App\Domain\User\actions\UserCantPostAction;
use App\Domain\User\Exceptions\UserExceedTotalPostsError;
use App\Domain\User\models\Follows;
use App\Domain\User\models\User;
use App\infra\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostApiController extends Controller
{
    /**
     * @param Request $request
     * @param PostRepository $postRepository
     * @return Collection
     * @throws BindingResolutionException
     */
    public function index(Request $request, PostRepository $postRepository)
    {
        $user_id = null;
        if($request->filter === "follows"){
            $user_id = Follows::where('follower_id', Auth::user()->id)->pluck('followered_id');
        }
        return $postRepository->allPosts($user_id);
    }

    /**
     * @return mixed
     */
    public function replyPosts()
    {
        return ReplyPost::whereUserId(Auth::user()->id)->with('post.user')->get();
    }

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
        return Post::create([
            "user_id" => $user->id,
            ...$request->validated()
        ]);
    }

    public function search(Request $request, PostRepository $postRepository)
    {
        $search = $request->search;
        $keywords = explode(' ', $search);
        $posts = Post::where(function ($query) use ($keywords){
            foreach ($keywords as $word) {
                $query->orWhere('content', 'like', '%'.$word.'%');
            }
        })->select("user_id","content","user_id", "id as post_id");
        $quotePosts = QuotePost::where(function ($query) use ($keywords){
            foreach ($keywords as $word) {
                $query->orWhere('content', 'like', '%'.$word.'%');
            }
        })->select("user_id","content","user_id", "post_id");;
        return $posts->union($quotePosts)->get();
    }
}
