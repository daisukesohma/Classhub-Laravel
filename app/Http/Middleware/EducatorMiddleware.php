<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EducatorMiddleware
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
            
            session()->forget('user_mode');
            session()->put('user_mode', 'educator');
            
            if (request()->has('switch') && request()->get('switch') == 'educator')
                return redirect()->route('educator.dashboard');
            
            //  Educator only
            if (Auth::user()->educator)
                return $next($request);
            
            // Parent
            return redirect()->back();
        }
        
        return redirect()->route('home');
    }
}
