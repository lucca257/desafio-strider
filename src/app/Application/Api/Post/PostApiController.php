<?php

namespace App\Application\Api\Post;

use App\Domain\Post\model\Post;
use App\Domain\Post\model\Repost;
use App\infra\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $posts = Post::with('user','repost','repost.user');
        if($request->filter === "user"){
            $posts->whereUserId(Auth::user()->id);
        }
        $posts = $posts->get();
        $reposts = $posts->pluck('repost')->toArray();
        $allPosts = array_merge($reposts, $posts->toArray());
        return response($allPosts);
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
