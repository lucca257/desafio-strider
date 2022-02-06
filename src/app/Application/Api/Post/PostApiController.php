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
    public function index()
    {
        $reposts = Repost::with('user','post','post.user')->get();
        $posts = $reposts->pluck('post')->toArray();
        $allPosts = array_merge($reposts->toArray(), $posts);
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
