<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class CheckManager
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
        if (Auth::user()->role != 'manager') {
            return redirect('/login');
        }
        return $next($request);
    }
}
