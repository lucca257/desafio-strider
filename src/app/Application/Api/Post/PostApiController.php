<?php

namespace App\Application\Api\Post;

use App\Domain\Post\model\Post;
use App\Domain\Post\model\QuotePost;
use App\Domain\Post\model\Repost;
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
            $user = User::all()->random();
            Auth::setUser($user);
            $filter = Follows::where('follower_id', Auth::user()->id)->pluck('followered_id');
            $posts = $posts->whereIn('user_id', $filter);
            $reposts = $reposts->whereIn('user_id', $filter);
            $quoteposts = $quotePosts->whereIn('user_id', $filter);
        }

        $posts = $posts->get();
        $reposts = $reposts->get();
        $quoteposts = $quotePosts->get();

        $allPosts = new Collection;
        $allPosts = $allPosts->merge($posts);
        $allPosts = $allPosts->merge($reposts);
        return $allPosts->merge($quoteposts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
