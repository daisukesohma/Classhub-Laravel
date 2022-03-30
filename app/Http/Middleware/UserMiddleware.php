<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
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
            
            // Parent and Educator
            if (!Auth::getUser()->is_admin) {
                
                if (request()->has('switch')) {
                    
                    if (request()->switch == 'parent') {
                        session()->forget('user_mode');
                        session()->put('user_mode', 'parent');
                        return redirect()->route('home');
                        
                    } else {
                        session()->forget('user_mode');
                        session()->put('user_mode', 'educator');
                        return redirect()->route('educator.dashboard');
                    }
                }
                
                return $next($request);
            }
            
            // Admin
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('home');
    }
}
