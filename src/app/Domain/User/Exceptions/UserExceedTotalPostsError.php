<?php

namespace App\Domain\User\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserExceedTotalPostsError extends Exception
{
    /**
     * Render the exception into an HTTP response.
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([
            "message" => "Whoops, did you exceed the total posts. You can post only 5 posts in a day."
        ],422);
    }
}

