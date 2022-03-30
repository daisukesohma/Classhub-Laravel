<?php

namespace App\Http\Controllers;

use App\Jobs\IntercomJob;
use App\Jobs\SendEmailJob;
use App\Mail\WelcomeEducator;
use App\Mail\WelcomeUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    protected $newUser = false;
    
    public function redirect($provider, $userType = false)
    {
        if ($userType) {
            Session::put('user_type', $userType);
        }
        
        return Socialite::driver($provider)->redirect();
    }
    
    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            
            \Log::info('Provider : ' . $provider);
            \Log::info('User Info : ' . $socialUser->id);
            
            $user = $this->createUser($socialUser, $provider);
            
            Auth::login($user, true);
            
            if ($user->educator || $user->user_type == 'educator') {
                $route = 'educator.dashboard';
            } else {
                $route = 'parent.dashboard';
            }
            
            if ($this->newUser) {
                Session::put('new_user', true);
                return redirect()->route('home');
            }
            
            return redirect()->route($route);
            
        } catch (\Exception $e) {
            \Log::info('Catch social error: ' . $e->getMessage());
            Session::flash('signup_error', true);
            return redirect()->route('home')
                ->withErrors([\Lang::get('messages.error'), $e->getMessage()]);
        }
        
    }
    
    function createUser($socialUser, $provider)
    {
        $user = User::where('provider_id', $socialUser->id)
            ->orWhere('email', $socialUser->email)->first();
        
        if (!$user) {
            $user = User::create([
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'password' => Hash::make('secret'),
                'user_type' => Session::get('user_type'),
                'provider' => $provider,
                'provider_id' => $socialUser->id,
                'subscribe_intercom' => true
            ]);
            
            $this->newUser = true;
            
            return User::findOrFail($user->id);
        }
        
        if (!$user->provider_id) {
            $user->update([
                'provider' => $provider,
                'provider_id' => $socialUser->id,
            ]);
        }
        
        return $user;
        
    }
    
    public function sendEmailAndIntercom(Request $request)
    {
        $user = Auth::user();
        
        $user->update(['user_type' => $request->get('user_type')]);
        
        if ($request->get('user_type') == 'parent') {
            $job = new SendEmailJob($user->email, new WelcomeUser($user, $user->email));
            $this->dispatch($job);
        } else {
            $job = new SendEmailJob($user->email, new WelcomeEducator($user, $user->email));
            $this->dispatch($job);
        }
        
        // Intercom Data
        $customData = [
            'Educator' => $request->get('user_type') == 'educator' ? true : false,
            'Bookings no' => $user->educator ? $user->educatorBookings()->count() : $user->bookings()->count(),
            'Impressions no' => $user->searchAppearances()->count(),
            'Views no' => $user->views()->count(),
            'Lessons no' => $user->lessons()->count(),
            'Stripe Connected' => false
        ];
        
        if ($request->get('user_type') == 'educator') {
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
            'unsubscribed_from_emails' => false,
        ];
        
        $intercomJob = new IntercomJob($user, $data);
        
        $this->dispatch($intercomJob);
        
        return response()->json([
            'status' => true
        ]);
    }
}
