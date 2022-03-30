<?php

namespace App\Http\Controllers;

use App\Helpers\ClassHubHelper;
use App\Jobs\IntercomJob;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function login(Request $request)
    {
        // Automatic activate tutor on login
        $user = User::where('email', $request->email)->first();
        
        if(!$user){
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.login.error')]
            ]);
        }
        
        if (!$user->active) {
            $user->update([
                'is_online' => 1,
                'active' => 1
            ]);
        }
        
        
        if (Auth::attempt($request->only(['email', 'password']),
            
            $request->has('remember') ? true : false)) {
            
            $user = Auth::user();
            
            // Last login
            $user->update(['last_login' => Carbon::now()]);
            
            if ($user->is_admin) {
                $route = route('admin.dashboard');
                return response()->json([
                    'status' => true,
                    'user_id' => Auth::user()->id,
                    'username' => Auth::user()->name,
                    'redirect_url' => $route
                ]);
            }
            
            // Intercom Data
            $customData = [
                'Educator' => $user->user_type == 'educator' || $user->educator ? true : false,
                'Educator Type' => Auth::user()->educator ? (Auth::user()->educator->user_type == 1
                    ? 'Type 1' : 'Type 2') : '',
                'Bookings no' => $user->educator ? $user->educatorBookings()->count() : $user->bookings()->count(),
                'Impressions no' => $user->searchAppearances()->count(),
                'Views no' => $user->views()->count(),
                'Lessons no' => $user->lessons()->count(),
                'Stripe Connected' => $user->stripe_acct_id ? true : false,
            ];
            
            if ($user->user_type == 'educator') {
                $educatorData = [
                    'List Class' => $user->lessonsWithTrashed()->count() ? true : false,
                    'Profile Complete' => $user->educator ? true : false
                ];
                $customData = array_merge($customData, $educatorData);
            }
            
            $data = [
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'signed_up_at' => Carbon::parse($user->created_at)->getTimestamp(),
                'custom_attributes' => $customData,
                'unsubscribed_from_emails' => !$user->subscribe_intercom,
            ];
            
            $intercomJob = new IntercomJob($user, $data);
            
            $this->dispatch($intercomJob);
            
            
            if ($user->educator || $user->user_type == 'educator') {
                $route = route('educator.dashboard');
                session()->forget('user_mode');
                session()->put('user_mode', 'educator');
                session()->put('show_trusted', true);
            } else {
                $route = route('home');
                session()->forget('user_mode');
                session()->put('user_mode', 'parent');
            }
            
            if ($request->request_tutor) {
                return response()->json([
                    'status' => true,
                    'request_tutor' => 'form#request-tutor button',
                ]);
            }
            
            return response()->json([
                'status' => true,
                'user_id' => Auth::user()->id,
                'username' => Auth::user()->name,
                'redirect_url' => $request->get('redirect_url') ? $request->get('redirect_url') : $route
            ]);
            
            
        } else {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.login.error')]
            ]);
        }
    }
    
    public function logout()
    {
        Auth::logout();
        
        session()->forget('user_mode');
        
        return redirect()->route('home');
    }
    
}
