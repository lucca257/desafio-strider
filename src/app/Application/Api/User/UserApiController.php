<?php

namespace App\Application\Api\User;

use App\Domain\User\models\User;
use App\Domain\User\repository\UserRepository;
use App\infra\Http\Controllers\Controller;

class UserApiController extends Controller
{
    public function show(string $user_id, UserRepository $userRepository)
    {
        return $userRepository->details($user_id);
    }
}
