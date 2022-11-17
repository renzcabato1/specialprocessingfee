<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Requestor
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
        if (Auth::check() && Auth::user()->role == 3 || Auth::check() && Auth::user()->role == 2) {
            return redirect('requests');
        } elseif (Auth::check() && Auth::user()->role == 4) {
            return redirect('for-review');
        } elseif (Auth::check() && Auth::user()->role == 5) {
            return redirect('for-verification');
        }
    }
}
