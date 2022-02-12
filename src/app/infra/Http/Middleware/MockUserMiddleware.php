<?php

namespace App\infra\Http\Middleware;

use App\Domain\User\models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MockUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $request->headers->set('Accept', 'application/json');
        if(env('APP_ENV') === 'local'){
            Auth::setUser(User::first());
        }
        return $next($request);
    }
}
