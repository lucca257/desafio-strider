<?php

namespace App\Domain\User\actions;

use App\Domain\User\repository\UserRepository;

class UserCantPostAction
{
    public function __construct(public UserRepository $repository){}

    public function execute(string $user_id): bool
    {
        $total_posts = $this->repository->totalPosts($user_id);
        return $total_posts >= 6;
    }
}
