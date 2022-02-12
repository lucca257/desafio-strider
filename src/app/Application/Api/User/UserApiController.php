<?php

namespace App\Application\Api\User;

use App\Domain\User\models\User;
use App\Domain\User\repository\UserRepository;
use App\infra\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    public function __construct(private UserRepository $userRepository){}

    public function show($user_id = null)
    {
        if(!$user_id){
            $user_id = Auth::user()->id;
        }
        return $this->userRepository->details($user_id);
    }

    public function follow($followered_id = null)
    {
        if(!$followered_id){
            $followered_id = User::all()->random()->id;
        }
        return $this->userRepository->follow(Auth::user()->id, $followered_id);
    }
}
