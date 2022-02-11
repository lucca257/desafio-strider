<?php

namespace App\Domain\Post\repository;

use App\Domain\Post\model\Post;

class PostRepository
{
    public function __construct(
        public Post $post
    ){}
}
