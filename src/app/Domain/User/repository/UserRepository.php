<?php

namespace App\Domain\User\repository;

use App\Domain\User\models\User;
use Carbon\Carbon;

class UserRepository
{
    public function __construct(
        public User $user
    ){}

    public function totalPostsInDay(string $user_id): int
    {
        $date = new Carbon();
        $user = $this->user->withCount([
            'posts' => function($query) use ($date){
                $query->whereDate('created_at',$date);
            },
            'reposts' => function($query) use ($date){
                $query->whereDate('created_at',$date);
            },
            'quotePosts' => function($query) use ($date){
                $query->whereDate('created_at',$date);
            }
        ])->find($user_id);
        return $user->posts_count + $user->reposts_count + $user->quote_posts_count;
    }

    public function details(string $user_id): \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
    {
        $relationships = ['posts', 'reposts', 'quotePosts', 'replyPosts'];
        return $this->user
            ->with($relationships)
            ->withCount([
                'followers',
                'followereds',
                ...$relationships
            ])
            ->find($user_id);
    }
}
