<?php

namespace App\Providers;

use App\Helpers\ClassHubHelper;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //\URL::forceScheme('https');
        
        view()->composer(
            ['parent.layouts.menu', 'parent.pages.inbox', 'parent.pages.messages',
                'educator.layouts.menu', 'educator.pages.inbox', 'educator.pages.messages'],
            function ($view) {
                
                $inboxUnreadCount = 0;
                $user = null;
                if (Auth::user()) {
                    $user = Auth::user();
                    $chats = $user->chats();
                    foreach ($chats as $chat) {
                        $inboxUnreadCount += $chat->unread_count;
                    }
                }
                
                $inboxUnreadCount = $inboxUnreadCount < 0 ? 0 : $inboxUnreadCount;
                //$inboxUnreadCount = $inboxUnreadCount > 99 ? '99+' : $inboxUnreadCount;
                
                $view->with(compact('user', 'inboxUnreadCount'));
            });
        
        view()->composer('frontend.layouts.master',
            function ($view) {
                
                $menu = 'frontend.layouts.menu';
                
                if (Auth::user()) {
                    
                    if (Auth::user()->educator || session()->get('user_mode') == 'educator') {
                        $menu = 'educator.layouts.menu';
                    }
                    
                    if (!Auth::user()->educator || session()->get('user_mode') == 'parent') {
                        $menu = 'parent.layouts.menu';
                    }
                }
                
                $view->with(compact('menu'));
            });
    }
}
