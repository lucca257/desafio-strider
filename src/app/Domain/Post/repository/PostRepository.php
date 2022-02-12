<?php

namespace App\Domain\Post\repository;

use App\Domain\Post\model\Post;
use App\Domain\Post\model\QuotePost;
use App\Domain\Post\model\Repost;
use App\Support\Helpers\PaginateHelper;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;

class PostRepository
{
    public function __construct(
        public Post $post,
        public Repost $repost,
        public QuotePost $quotePost
    ){}

    /**
     * @param \Illuminate\Support\Collection|null $user_id
     * @return Collection
     * @throws BindingResolutionException
     */
    public function allPosts(?\Illuminate\Support\Collection $user_id)
    {
        $posts = $this->post->with('user');
        $reposts = $this->repost->with('user', 'post.user');
        $quotePosts = $this->quotePost->with('user', 'post.user');

        if($user_id){
            $posts = $posts->whereIn('user_id', $user_id);
            $reposts = $reposts->whereIn('user_id', $user_id);
            $quotePosts = $quotePosts->whereIn('user_id', $user_id);
        }
        $posts = $posts->simplePaginate(5);
        $reposts = $reposts->simplePaginate(5);
        $quotePosts = $quotePosts->simplePaginate(5);
        $allPosts = new Collection;
        $allPosts = $allPosts->merge($posts->items());
        $allPosts = $allPosts->merge($reposts->items());
        $allPosts = $allPosts->merge($quotePosts->items());
        return PaginateHelper::paginate($allPosts,15);
    }
}
