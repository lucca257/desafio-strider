<?php

namespace App\Application\Api\Post;

use App\Domain\Post\model\Post;
use App\Domain\Post\model\QuotePost;
use App\Domain\Post\model\ReplyPost;
use App\Domain\Post\model\Repost;
use App\Domain\User\actions\UserCantPostAction;
use App\Domain\User\Exceptions\UserExceedTotalPostsError;
use App\Domain\User\models\Follows;
use App\Domain\User\models\User;
use App\infra\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        $posts = Post::with('user');
        $reposts = Repost::with('user', 'post.user');
        $quotePosts = QuotePost::with('user', 'post.user');

        if($request->filter === "follows"){
            $filter = Follows::where('follower_id', Auth::user()->id)->pluck('followered_id');
            $posts = $posts->whereIn('user_id', $filter);
            $reposts = $reposts->whereIn('user_id', $filter);
            $quotePosts = $quotePosts->whereIn('user_id', $filter);
        }

        $posts = $posts->get();
        $reposts = $reposts->get();
        $quotePosts = $quotePosts->get();

        $allPosts = new Collection;
        $allPosts = $allPosts->merge($posts);
        $allPosts = $allPosts->merge($reposts);
        return $allPosts->merge($quotePosts);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        //
    }
}
