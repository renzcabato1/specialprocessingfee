<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CorpSec
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
        if (Auth::user()->role_id == 4) {
            return $next($request);
        } elseif (Auth::user()->role_id == 3) {
            return redirect('requests');
        } elseif (Auth::user()->role_id == 5) {
            return redirect('for-verification');
        }
    }
}
