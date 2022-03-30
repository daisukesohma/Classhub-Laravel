<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
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
        if ($request->has('view_key')) {
            try {
                $user = User::where('email', base64_decode($request->view_key))->first();
                Auth::logout();
                Auth::login($user);
                
                return $next($request);
            } catch (\Exception $e) {
                return redirect()->route('home');
            }
        }
        
        if (Auth::check())
            return $next($request);
        
        if ($request->wantsJson())
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.auth.required', ['text' => ''])]
            ]);
        
        return redirect()->route('home')
            ->withErrors([\Lang::get('messages.auth.required', ['text' => ''])]);
    }
}
