<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Stripe\Account;
use Stripe\Stripe;

class StripeAccountType1User extends Controller
{
    public function setupAccount(Request $request)
    {
        
        
        try {
            
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            
            $stripeAccount = null;
            
            // Create Stripe Account if user doesn't have one
            if (Auth::user()->stripe_acct_id) {
                $stripeAccount = Account::retrieve([
                    'id' => Auth::user()->stripe_acct_id,
                    'expand' => ['individual']
                ]);
            } else {
                $stripeAccount = $this->createAccount($request, null);
            }
            
            // Create Bank Account if user doesn't have one
            if (!Auth::user()->bank_account) {
                $this->createBankAccount($request->stripe_token, $stripeAccount);
            }
            
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.icon.ok'), Lang::get('messages.profile.store')],
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()],
                'errors' => $e->getMessage()
            ]);
        }
    }
    
    
    public function createAccount($request, $identityDocuments)
    {
        // Account Type data
        if ($request->account_holder_type == 'individual') {
            $accountType = [
                'individual' => [
                    'email' => $request->email,
                ]
            ];
            
        } else {
            $accountType = [
                'company' => []
            ];
        }
        
        $account = [
            'type' => 'custom',
            'business_type' => $request->account_holder_type,
            'business_profile' => [
                'name' => $request->account_holder_type == 'company' ?
                    $request->business_name : $request->account_holder_name,
                'url' => route('page.educator', Auth::user()->slug)
            ],
            'default_currency' => $request->currency,
            'country' => $request->country ? $request->country : 'IE',
            'email' => Auth::user()->email,
            'settings' => [
                'payouts' => [
                    'schedule' => [
                        'interval' => 'manual'
                    ]
                ]
            ],
            'tos_acceptance' => [
                'date' => Carbon::now()->getTimestamp(),
                'ip' => $request->ip(),
            ],
        ];
        
        //$stripeAccount = Account::create(array_merge($account, $accountType));
        $stripeAccount = Account::create($account);
        
        Auth::user()->update([
            'stripe_acct_id' => $stripeAccount['id'],
        ]);
        
        return $stripeAccount;
    }
    
    public function createBankAccount($bankToken, $stripeAccount)
    {
        $bankAccount = Account::createExternalAccount(
            $stripeAccount['id'], ['external_account' => $bankToken]
        );
        
        Auth::user()->update([
            'bank_account' => $bankAccount['id'],
        ]);
        
        return $bankAccount;
    }
    
    
}
