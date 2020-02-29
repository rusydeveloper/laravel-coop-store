<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckTenant
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
        if (Auth::user()->role != 'admin') {
            if (Auth::user()->role != 'tenant') {
                return 'bukan tenant';
                // return redirect('/');
            }
        }
        return $next($request);
    }
}
