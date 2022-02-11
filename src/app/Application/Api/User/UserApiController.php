<?php

namespace App\Application\Api\User;

use App\Domain\User\models\User;
use App\Domain\User\repository\UserRepository;
use App\infra\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    public function __construct(private UserRepository $userRepository){}

    public function show(string $user_id)
    {
        return $this->userRepository->details($user_id);
    }

    public function follow(string $followered_id)
    {
        return $this->userRepository->follow(Auth::user()->id, $followered_id);
    }
}
