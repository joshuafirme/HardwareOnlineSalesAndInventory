<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class AccessLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $access_levels)
    {
        $allowed_access_levels = explode(':', $access_levels);
     
        if (in_array(Auth::user()->access_level, $allowed_access_levels)) {
            return $next($request);
        }
        return redirect('/');
    }
}
