<?php

namespace App\Http\Middleware;

use Closure;
use \App\User;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class IsModerator
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
        $userLogged = User::with('user_type')->find(Auth::user()->id);

        if(is_null($userLogged) || $userLogged->user_type->id == 1) {
            return response()->json(['message' => 'Insuffient privileges. You must be an xMod or higher.'], 401);
        }
        
        return $next($request);
    }
}
