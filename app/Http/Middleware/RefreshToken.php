<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class RefreshToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('logout');
        }

      
        $user->jwtoken = JWTAuth::fromUser($user);
        
        return $next($request);
    }
}
