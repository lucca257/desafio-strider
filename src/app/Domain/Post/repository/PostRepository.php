<?php

namespace App\Domain\Post\repository;

use App\Domain\Post\model\Post;
use App\Domain\Post\model\QuotePost;
use App\Domain\Post\model\Repost;
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
     */
    public function allPosts(?\Illuminate\Support\Collection $user_id): Collection
    {
        $posts = $this->post->with('user');
        $reposts = $this->repost->with('user', 'post.user');
        $quotePosts = $this->quotePost->with('user', 'post.user');

        if($user_id){
            $posts = $posts->whereIn('user_id', $user_id);
            $reposts = $reposts->whereIn('user_id', $user_id);
            $quotePosts = $quotePosts->whereIn('user_id', $user_id);
        }
        $posts = $posts->get();
        $reposts = $reposts->get();
        $quotePosts = $quotePosts->get();

        $allPosts = new Collection;
        $allPosts = $allPosts->merge($posts);
        $allPosts = $allPosts->merge($reposts);
        return $allPosts->merge($quotePosts);
    }
}
