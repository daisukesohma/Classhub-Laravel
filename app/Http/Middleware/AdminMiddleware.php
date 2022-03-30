<?php

namespace App\Http\Middleware;

use Closure;
use Composer\Util\AuthHelper;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // Admin
            if (Auth::getUser()->is_admin)
                return $next($request);

            // Parent and Educator
            $route = Auth::getUser()->educator ? 'educator.dashboard' : 'parent.dashboard';
            return redirect()->route($route);
        }

        return redirect()->route('home');
    }
}
