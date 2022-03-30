<?php

namespace App\Http\Controllers;

use App\Booking;
use App\BookingClass;
use App\Card;
use App\ErrorLog;
use App\Helpers\ClassHubHelper;
use App\Jobs\IntercomJob;
use App\Jobs\SendEmailJob;
use App\Mail\AccountUpdate;
use App\Mail\PaymentReceiptEducator;
use App\Mail\StripeAccountError;
use App\Mail\StripeAddlDocumentError;
use App\Mail\StripeDocumentError;
use App\Mail\StripeMccError;
use App\RefundRequest;
use App\Setting;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Self_;
use Stripe\Account;
use Stripe\Balance;
use Stripe\BalanceTransaction;
use Stripe\BankAccount;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Error\Api;
use Stripe\File;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Payout;
use Stripe\Person;
use Stripe\Refund;
use Stripe\Stripe;
use Stripe\Token;
use Stripe\Transfer;

class StripeController extends Controller
{
    const VAT_PERCENT = 0.23;
    const STRIPE_VAT_PERCENT = 0.23;
    const STRIPE_FEE_PERCENT_EU = 0.014;
    const STRIPE_FEE_PERCENT_NON_EU = 0.029;
    const STRIPE_FIXED_CHARGE = 25; // Cents
    const EU_COUNTRIES = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GB', 'GR', 'HR',
        'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK'];
    
    const INDIVIDUAL_PAYOUT_RULES = [
        'account_holder_name' => 'required',
        'account_number' => 'required',
        'country' => 'required',
        'currency' => 'required',
        'industry' => 'required',
    ];
    
    const INDIVIDUAL_PERSON_RULES = [
        'line1' => 'required',
        'line2' => 'required',
        'city' => 'required',
        'state' => 'required',
        'postal_code' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required',
        'day' => 'required|numeric',
        'month' => 'required|numeric',
        'year' => 'required|numeric',
        'country_code' => 'required',
        'phone_no' => 'required',
        'front_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        'back_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
    ];
    
    const COMPANY_PAYOUT_RULES = [
        'account_holder_name' => 'required',
        'business_name' => 'required',
        'business_tax_id' => 'required',
        'business_vat_id' => 'required',
        'line1' => 'required',
        'line2' => 'required',
        'city' => 'required',
        'state' => 'required',
        'postal_code' => 'required',
        'account_number' => 'required',
        'country' => 'required',
        'currency' => 'required',
        'industry' => 'required',
        'country_code' => 'required',
        'business_phone_no' => 'required',
    ];
    
    const COMPANY_PERSON_RULE = [
        'persons.*.first_name' => 'required',
        'persons.*.last_name' => 'required',
        'persons.*.email' => 'required',
        'persons.*.day' => 'required|numeric',
        'persons.*.month' => 'required|numeric',
        'persons.*.year' => 'required|numeric',
        'persons.*.country_code' => 'required',
        'persons.*.phone_no' => 'required|numeric',
        'persons.*.owner' => 'required',
        'persons.*.percent_owned' => 'required|numeric',
        'persons.*.line1' => 'required',
        'persons.*.line2' => 'required',
        'persons.*.city' => 'required',
        'persons.*.state' => 'required',
        'persons.*.title' => 'required',
        'persons.*.postal_code' => 'required',
        'persons.*.front_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        'persons.*.back_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
    ];
    
    public function validateAllFields(Request $request)
    {
        $errorMessages = [];
        
        if ($request->account_type == 'individual') {
            $payoutValidation = ClassHubHelper::validateData($request->all(), self::INDIVIDUAL_PAYOUT_RULES);
            $personValidation = ClassHubHelper::validateData($request->all(), self::INDIVIDUAL_PERSON_RULES);
            
            if (is_array($payoutValidation)) {
                $payout = false;
                $errorMessages = array_merge($errorMessages, $payoutValidation['messages']);
            } else {
                $payout = true;
            }
            
            if (is_array($personValidation)) {
                $person = false;
                $errorMessages = array_merge($errorMessages, $personValidation['messages']);
            } else {
                $person = true;
            }
            
        } else {
            $payoutValidation = ClassHubHelper::validateData($request->all(), self::COMPANY_PAYOUT_RULES);
            $personValidation = ClassHubHelper::validateData($request->all(), self::COMPANY_PERSON_RULE);
            
            if (is_array($payoutValidation)) {
                $payout = false;
                $errorMessages = array_merge($errorMessages, $payoutValidation['messages']);
            } else {
                $payout = true;
            }
            
            if (is_array($personValidation)) {
                $person = false;
                $errorMessages = array_merge($errorMessages, $personValidation['messages']);
            } else {
                $person = true;
            }
        }
        
        /*$paymentTermsValidation = ClassHubHelper::validateData($request->all(), ['payment_terms' => 'required']);
        
        if (is_array($paymentTermsValidation)) {
            $paymentTerms = false;
            $errorMessages = array_merge($errorMessages, $paymentTermsValidation['messages']);
        } else {
            $paymentTerms = true;
        }*/
        
        return response()->json([
            'status' => $payout && $person, // && $paymentTerms,
            'payout' => $payout,
            'person' => $person,
            //'payment_terms' => $paymentTerms,
            'messages' => $errorMessages
        ]);
    }
    
    public function setupAccount(Request $request)
    {
        $validationResults = $this->validateAllFields($request)->getOriginalContent();
        
        if (!$validationResults['status']) {
            return response()->json([
                'status' => false,
                'messages' => $validationResults['messages']
            ]);
        }
        
        // Validate percent own for company
        if ($request->account_holder_type == 'company') {
            $percentOwn = 0;
            
            foreach ($request->persons as $index => $person) {
                $percentOwn += is_numeric($person['percent_owned']) && $person['owner'] == 'yes' ?
                    $person['percent_owned'] : 0;
            }
            
            if ($percentOwn < 76 || $percentOwn > 100) {
                return response()->json([
                    'status' => false,
                    'messages' => ['Percent owned must be minimum of 76 and maximum of 100']
                ]);
            }
        }
        
        try {
            
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            
            $stripeAccount = null;
            
            // Create identity document files for Persons
            $identityDocuments = $this->uploadIdentityDocuments($request);
            
            // Create Stripe Account if user doesn't have one
            if (Auth::user()->stripe_acct_id) {
                $stripeAccount = Account::retrieve([
                    'id' => Auth::user()->stripe_acct_id,
                    'expand' => ['individual']
                ]);
            } else {
                $stripeAccount = $this->createAccount($request, $identityDocuments);
            }
            
            // Create Bank Account if user doesn't have one
            if (!Auth::user()->bank_account) {
                $this->createBankAccount($request->stripe_token, $stripeAccount);
            }
            
            // Create or update Persons of Account Holder base on Account type
            if ($stripeAccount['business_type'] == 'company') {
                $this->createPersons($request, $stripeAccount, $identityDocuments);
            }
            
            // Intercom Data
            $customData = [
                'Educator' => true,
                'Stripe Connected' => true,
            ];
            
            
            $data = [
                'user_id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'name' => Auth::user()->name,
                'signed_up_at' => Carbon::parse(Auth::user()->created_at)->getTimestamp(),
                'custom_attributes' => $customData,
            ];
            
            $intercomJob = new IntercomJob(Auth::user(), $data);
            
            $this->dispatch($intercomJob);
            
            return response()->json([
                'status' => true,
                'messages' => [
                    Lang::get('messages.icon.ok'),
                    Auth::user()->educator->user_type == 1 ? Lang::get('messages.profile.store') : Lang::get('messages.stripe-account.store')
                ],
                'redirect_url' => Auth::user()->educator->user_type == 1 ? route('educator.dashboard') : route('educator.lesson.create')
            ]);
            
        } catch (\Exception $e) {
            $stripeUnderAgeError = 'at least 13 years';
            $underAgeErrorMsg = 'Must be at least 18 years of age to use Stripe';
            $erroMessage = strpos($e->getMessage(), $stripeUnderAgeError) !== false ? $underAgeErrorMsg : $e->getMessage();
            
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $erroMessage],
                'errors' => $e->getTraceAsString()
            ]);
        }
    }
    
    
    public function createAccount($request, $identityDocuments)
    {
        // Account Type data
        if ($request->account_holder_type == 'individual') {
            $accountType = [
                'individual' => [
                    'address' => [
                        'line1' => $request->line1 . ' ,' . $request->city,
                        'line2' => $request->line2,
                        'postal_code' => $request->postal_code,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country' => $request->country ? $request->country : 'IE',
                    ],
                    'dob' => [
                        'day' => $request->day,
                        'month' => $request->month,
                        'year' => $request->year,
                    ],
                    'email' => $request->email,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->country_code . $request->phone_no,
                    'verification' => [
                        'document' => [
                            'front' => $identityDocuments[0]['front']['id'],
                            'back' => $identityDocuments[0]['back']['id']
                        ]
                    ]
                ]
            ];
            
        } else {
            $accountType = [
                'company' => [
                    'address' => [
                        'line1' => $request->line1 . ' ,' . $request->city,
                        'line2' => $request->line2,
                        'postal_code' => $request->postal_code,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country' => $request->country ? $request->country : 'IE',
                    ],
                    'name' => $request->business_name,
                    'tax_id' => $request->business_tax_id,
                    'vat_id' => $request->business_vat_id,
                    'directors_provided' => true,
                    'phone' => $request->country_code . $request->business_phone_no,
                ]
            ];
        }
        
        $account = [
            'type' => 'custom',
            'business_type' => $request->account_holder_type,
            'business_profile' => [
                'mcc' => $request->industry,
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
            'requested_capabilities' => [
                'card_payments',
                'transfers'
            ]
        ];
        
        $stripeAccount = Account::create(array_merge($account, $accountType));
        
        Auth::user()->update([
            'stripe_acct_id' => $stripeAccount['id'],
        ]);
        
        try {
            Auth::user()->educator->update(
                ['dob' => Carbon::parse($request->year . '-' . $request->month . '-' . $request->day)]
            );
        } catch (\Exception $e) {
        }
        
        return $stripeAccount;
    }
    
    public static function deleteAccount($accountId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
        $account = Account::retrieve($accountId);
        
        $account->delete();
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
    
    public function updateBankAccount(Request $request)
    {
        $user = Auth::user();
        $oldBankAccount = $user->bank_account;
        
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            
            $bankAccount = Account::createExternalAccount(
                $user->stripe_acct_id, ['external_account' => $request->stripe_token]
            );
            
            Account::updateExternalAccount($user->stripe_acct_id, $bankAccount['id'],
                ['default_for_currency' => true]);
            
            Auth::user()->update([
                'bank_account' => $bankAccount['id'],
            ]);
            
            Account::deleteExternalAccount($user->stripe_acct_id, $oldBankAccount);
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.icon.ok'), 'Bank Account change successfully']
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
        
        return $bankAccount;
    }
    
    public function uploadIdentityDocuments($request)
    {
        $identityDocuments = [];
        
        if ($request->account_holder_type == 'individual') {
            $fp1 = fopen($request->file('front_photo')->path(), 'r');
            $fp2 = fopen($request->file('back_photo')->path(), 'r');
            
            $fileFront = File::create([
                'purpose' => 'identity_document',
                'file' => $fp1
            ]);
            
            $fileBack = File::create([
                'purpose' => 'identity_document',
                'file' => $fp2
            ]);
            
            array_push($identityDocuments, ['front' => $fileFront, 'back' => $fileBack]);
            
        } else {
            
            foreach ($request->file('persons') as $files) {
                $fp1 = fopen($files['front_photo']->path(), 'r');
                $fp2 = fopen($files['back_photo']->path(), 'r');
                
                $fileFront = File::create([
                    'purpose' => 'identity_document',
                    'file' => $fp1
                ]);
                
                $fileBack = File::create([
                    'purpose' => 'identity_document',
                    'file' => $fp2
                ]);
                
                array_push($identityDocuments, ['front' => $fileFront, 'back' => $fileBack]);
            }
        }
        
        return $identityDocuments;
    }
    
    public function createPersons($request, $stripeAccount, $identityDocuments)
    {
        $accountOpener = true;
        
        foreach ($request->persons as $index => $person) {
            Account::createPerson($stripeAccount['id'], [
                'address' => [
                    'line1' => $person['line1'],
                    'line2' => $person['line2'],
                    'postal_code' => $person['postal_code'],
                    'city' => $person['city'],
                    'state' => $person['state'],
                    'country' => isset($person['country']) ? $person['country'] : 'IE',
                ],
                'dob' => [
                    'day' => $person['day'],
                    'month' => $person['month'],
                    'year' => $person['year'],
                ],
                'email' => $person['email'],
                'first_name' => $person['first_name'],
                'last_name' => $person['last_name'],
                'phone' => $person['country_code'] . $person['phone_no'],
                'relationship' => [
                    'title' => $person['title'],
                    'director' => true,
                    'account_opener' => $accountOpener,
                    'owner' => $accountOpener,
                    'percent_ownership' => $accountOpener ? $person['percent_owned'] : null,
                ],
                'verification' => [
                    'document' => [
                        'front' => $identityDocuments[$index]['front']['id'],
                        'back' => $identityDocuments[$index]['back']['id']
                    ]
                ]
            ]);
            
            $accountOpener = false;
        }
    }
    
    public static function createCustomer()
    {
        $customer = Customer::create([
            'email' => Auth::user()->email,
            'name' => Auth::user()->name,
            'description' => 'Class Hub customer',
        ]);
        
        Auth::user()->update(['stripe_cust_id' => $customer['id']]);
        
        return $customer;
    }
    
    public static function saveCard($request)
    {
        $card = Customer::createSource(Auth::user()->stripe_cust_id,
            ['source' => $request->stripeToken]
        );
        
        Card::create([
            'user_id' => Auth::user()->id,
            'card_id' => $card['id'],
            'last4' => $card['last4'],
            'brand' => $card['brand'],
            'country' => $card['country'],
            'is_default' => 0
        ]);
        
        return $card;
    }
    
    public static function setDefaultCard($cardId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
        try {
            
            $card = Auth::user()->cards()->where('card_id', $cardId)->first();
            
            Customer::update(Auth::user()->stripe_cust_id,
                [
                    'default_source' => $cardId
                ]
            );
            
            DB::beginTransaction();
            
            Auth::user()->cards()->update(['is_default' => 0]);
            
            $card->update(['is_default' => 1]);
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'messages' => [
                    Lang::get('messages.icon.ok'),
                    'Card Ending ' . $card->last4 . ' set as default'
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }
    
    public function deleteCard($cardId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
        try {
            Customer::deleteSource(Auth::user()->stripe_cust_id, $cardId);
            
            $card = Auth::user()->cards()->where('card_id', $cardId)->first();
            
            $card->delete();
            
            $job = new SendEmailJob(Auth::user()->email, new AccountUpdate(Auth::user(), Auth::user()->email));
            
            $this->dispatch($job);
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.icon.ok'), 'Card deleted']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }
    
    public static function getBookingFees($user, $classFeeAmt, $serviceFeeAmt, $country)
    {
        $stripeFeePercent = in_array($country, self::EU_COUNTRIES) ? self::STRIPE_FEE_PERCENT_EU :
            self::STRIPE_FEE_PERCENT_NON_EU;
        
        if ($user) {
            $tutorFeePercent = $user->educator->provider_fee ? $user->educator->provider_fee / 100
                : Setting::get('provider_fee') / 100;
        } else {
            $tutorFeePercent = Setting::get('provider_fee') / 100;
        }
        
        $tutorFeeAmt = ClassHubHelper::roundCents($tutorFeePercent * $classFeeAmt);
        
        $tutorVatAmt = ClassHubHelper::roundCents($tutorFeeAmt * self::VAT_PERCENT);
        
        $stripeFeeAmt = ClassHubHelper::roundCents($stripeFeePercent * ($classFeeAmt + $serviceFeeAmt))
            + self::STRIPE_FIXED_CHARGE;
        
        $stripeVatAmt = ClassHubHelper::roundCents($stripeFeeAmt * self::STRIPE_VAT_PERCENT);
        
        $stripeTotalFeeAmt = $stripeFeeAmt + $stripeVatAmt;
        
        $applicationFee = ($serviceFeeAmt + $tutorFeeAmt + $tutorVatAmt) - $stripeTotalFeeAmt;
        
        Log::info('-------------------------------------------------');
        Log::info(' Fee Calculation (Card Country): ' . $country);
        Log::info(' Fee Calculation (Class price): ' . $classFeeAmt);
        Log::info(' Fee Calculation (Service fee amount): ' . $serviceFeeAmt);
        Log::info(' Fee Calculation (Stripe fee percent): ' . $stripeFeePercent);
        Log::info(' Fee Calculation (Stripe fee amount): ' . $stripeFeeAmt);
        Log::info(' Fee Calculation (Stripe vat percent): ' . self::STRIPE_VAT_PERCENT);
        Log::info(' Fee Calculation (Stripe vat amount): ' . $stripeVatAmt);
        Log::info(' Fee Calculation (Stripe total amount): ' . $stripeTotalFeeAmt);
        Log::info(' Fee Calculation (Classhub fee percent): ' . $tutorFeePercent);
        Log::info(' Fee Calculation (Tutor fee amount): ' . $tutorFeeAmt);
        Log::info(' Fee Calculation (Tutor vat amount): ' . $tutorVatAmt);
        Log::info(' Fee Calculation (Application fee amount): ' . $applicationFee);
        Log::info('-------------------------------------------------');
        
        return [$applicationFee, $stripeTotalFeeAmt];
    }
    
    public static function processPaymentIntent($request, $educator, $classFeeAmt, $serviceFeeAmt)
    {
        if (!$request->payment_method_id && !$request->payment_intent_id) {
            
            return [
                'status' => false,
                'data' => [
                    'status' => false,
                    'messages' => [Lang::get('messages.error'), 'Invalid Payment Method']
                ]
            ];
        }
        
        list($applicationFee, $stripeTotalFeeAmt) = self::getBookingFees($educator, $classFeeAmt,
            $serviceFeeAmt, $request->card_country);
        
        // Retrieve Payment intent
        if ($request->payment_intent_id) {
            
            $intent = PaymentIntent::retrieve(
                [
                    'id' => $request->payment_intent_id
                ],
                [
                    'stripe_account' => $educator->stripe_acct_id
                ]
            );
            
        } // create intent if payment_method_id is set
        else if ($request->payment_method_id) {
            
            if ($request->customer) {
                $paymentMethod = [
                    'payment_method' => $request->payment_method_id,
                    'customer' => $request->customer
                ];
            } else {
                $paymentMethod = [
                    'payment_method' => $request->payment_method_id,
                ];
            }
            
            $sharedPaymentMethod = PaymentMethod::create(
                $paymentMethod,
                [
                    'stripe_account' => $educator->stripe_acct_id
                ]
            );
            
            $intentData = [
                'payment_method_types' => ['card'],
                'payment_method' => $sharedPaymentMethod->id,
                'amount' => $classFeeAmt + $serviceFeeAmt,
                'currency' => 'eur',
                'confirmation_method' => 'manual',
            ];
            
            if ($applicationFee > 0) {
                $intentData = array_merge($intentData, ['application_fee_amount' => $applicationFee]);
            }
            
            $intent = PaymentIntent::create(
                $intentData, ['stripe_account' => $educator->stripe_acct_id]
            );
            
        }
        
        $intent->confirm();
        
        // Requires extra action by stripe js
        if ($intent->status == 'requires_action' &&
            $intent->next_action->type == 'use_stripe_sdk') {
            
            //Tell the client to handle the action
            return [
                'status' => false,
                'data' => [
                    'status' => true,
                    'requires_action' => true,
                    'payment_intent_client_secret' => $intent->client_secret,
                    'connect_account_id' => $educator->stripe_acct_id
                ]
            ];
        } else if ($intent->status !== 'succeeded') {
            
            // Payment failed
            return [
                'status' => false,
                'data' => [
                    'status' => false,
                    'messages' => [Lang::get('messages.error'), 'Invalid PaymentIntent status']
                ]
            ];
            
        } else {
            
            // Handle post-payment fulfillment
            return [
                'status' => true,
                'intent' => $intent,
                'application_fee' => $applicationFee,
                'stripe_fee' => $stripeTotalFeeAmt
            ];
        }
    }
    
    public static function transferStripeFee($amount, $booking, $user)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
        return Transfer::create([
            'amount' => $amount,
            'currency' => 'eur',
            'destination' => $user->stripe_acct_id,
            'description' => 'Stripe fee reversed by Classhub on Booking # 
                ' . ClassHubHelper::getbookingCode($booking)
        ]);
    }
    
    public static function refundCharge($booking, $chargeTxn, $amount, $educator)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
        $data = [
            'charge' => $chargeTxn->txn_id,
            'amount' => $amount,
            'reason' => 'requested_by_customer',
        ];
        
        if ($booking->application_fee > 0) {
            $data = array_merge($data, ['refund_application_fee' => true]);
        }
        
        return Refund::create(
            $data,
            [
                'stripe_account' => $educator->stripe_acct_id
            ]
        );
    }
    
    public static function payout($educator, $booking, $amount, $classId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
        $bookingCode = ClassHubHelper::getbookingCode($booking);

        $transaction = json_decode(Transaction::where('booking_id', $booking->id)->where('type', 'charge')->first()->txn_details);

        $balanceTransaction = BalanceTransaction::retrieve(
            [
                'id' => $transaction->balance_transaction
            ],
            [
                'stripe_account' => $educator->stripe_acct_id
            ]
        );

        if ($balanceTransaction->exchange_rate) {
            $exchangedAmount = ClassHubHelper::roundCents($amount * $balanceTransaction->exchange_rate);

            return Payout::create(
                [
                    'amount' => $exchangedAmount,
                    'currency' => $balanceTransaction->currency,
                    'source_type' => 'card',
                    'description' => 'Classhub Payout / Booking Code: ' . $bookingCode . ', Class #' . $classId,
                    'statement_descriptor' => 'CH_PAYOUT/' . $bookingCode . '/' . $classId,
                ],
                [
                    'stripe_account' => $educator->stripe_acct_id
                ]
            );
        }
        
        return Payout::create(
            [
                'amount' => $amount,
                'currency' => 'eur',
                'source_type' => 'card',
                'description' => 'Classhub Payout / Booking Code: ' . $bookingCode . ', Class #' . $classId,
                'statement_descriptor' => 'CH_PAYOUT/' . $bookingCode . '/' . $classId,
            ],
            [
                'stripe_account' => $educator->stripe_acct_id
            ]
        );
    }
    
    public static function getPayableAndPayoutDetails($booking)
    {
        $totalPayableAmount = 0;
        $totalPayoutAmount = 0;
        $amountPayablePerClass = ($booking->amount - ($booking->application_fee + $booking->stripe_fee))
            / $booking->classes->count();
        
        foreach ($booking->classes as $bookingClass) {
            
            if ($bookingClass->status === 'cancelled')
                continue;
            
            $refundRequest = RefundRequest::where('booking_id', $booking->id)
                ->where('lesson_class_id', $bookingClass->class->id)->first();
            
            if ($refundRequest && ($refundRequest->has_been_payout || $refundRequest->in_progress)) {
                continue;
            }
            
            $totalPayableAmount += $amountPayablePerClass;
            $totalPayoutAmount += $bookingClass->payout_amount;
        }
        
        $totalPayableAmount = ClassHubHelper::roundCents($totalPayableAmount);
        
        return [$totalPayableAmount, $totalPayoutAmount];
    }
    
    public static function requestPayout()
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
        $bookingClasses = BookingClass::with('booking')->where('status', 'completed')
            ->whereNull('transaction_id')->where('payout_amount', 0)->get();
        
        foreach ($bookingClasses as $bookingClass) {
            
            $booking = $bookingClass->booking;
            
            $classEndAt = Carbon::parse($bookingClass->class->date . ' ' . $bookingClass->class->end_time);
            
            if ($classEndAt->isFuture() || Carbon::now()->diffInHours($classEndAt, false) >= -24)
                continue;
            
            $refundRequest = RefundRequest::where('booking_id', $booking->id)
                ->where('lesson_class_id', $bookingClass->class->id)->first();
            
            if ($refundRequest && ($refundRequest->has_been_payout || $refundRequest->in_progress)) {
                continue;
            }
            
            list($totalPayableAmount, $totalPayoutAmount) = self::getPayableAndPayoutDetails($booking);
            
            $amountPayablePerClass = ClassHubHelper::roundCents(($booking->amount - ($booking->application_fee +
                        $booking->stripe_fee)) / $booking->classes->count());
            
            $unpaidAmount = $totalPayableAmount - $totalPayoutAmount;
            
            $amountPayablePerClass = $amountPayablePerClass > $unpaidAmount ? $unpaidAmount : $amountPayablePerClass;
            
            $payout = null;
            
            $user = $booking->lesson->user;
            
            // Skipped for test users
            if (strpos($user->email, '@test.com'))
                continue;

            try {
                
                // Add funds in test mode
                if (env('APP_ENV') !== 'production') {
                    self::addFunds($user);
                }
                
                $payout = self::payout($user, $booking, $amountPayablePerClass, $bookingClass->class->id);
                
                DB::beginTransaction();
                
                $transaction = Transaction::create([
                    'booking_id' => $booking->id,
                    'txn_id' => $payout->id,
                    'amount' => $payout->amount,
                    'txn_details' => json_encode($payout),
                    'status' => $payout['status'],
                    'type' => $payout['object']
                ]);
                
                $bookingClass->update([
                    'transaction_id' => $transaction->id,
                    'payout_amount' => $payout->amount
                ]);
                
                DB::commit();
                
                $job = new SendEmailJob($user->email,
                    new PaymentReceiptEducator($booking, $bookingClass->class, $amountPayablePerClass, $user->email));
                
                dispatch($job);
                
            } catch (\Exception $e) {
                DB::rollBack();
                
                if ($payout) {
                    ErrorLog::create([
                        'user_id' => $user->id,
                        'type' => 'payout',
                        'data' => 'Booking ID: ' . $booking->id .
                            ', Class ID: ' . $bookingClass->lesson_class_id . ' /  Reason : ' . $e->getMessage(),
                        'details' => json_encode($payout),
                        'status' => 'failed'
                    ]);
                    
                    $payout->cancel();
                } else {
                    ErrorLog::create([
                        'user_id' => $user->id,
                        'type' => 'payout',
                        'data' => 'Booking ID: ' . $booking->id .
                            ', Class ID: ' . $bookingClass->lesson_class_id . ' / Reason : ' .
                            $e->getMessage(),
                        'details' => $e->getTraceAsString(),
                        'status' => 'failed'
                    ]);
                    
                }
            }
        }
    }
    
    public function accountUpdatedWebHook()
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            
            $data = \request()->all();
            
            // Person updated event
            if ($data['type'] == 'person.updated') {
                $object = $data['data']['object'];
                
                if (isset($object['object']) && $object['object'] === 'person') {
                    
                    $person = $object;
                    
                    if ($person['verification']['status'] == 'unverified') {
                        
                        $allRequirements = array_merge($person['requirements']['currently_due'],
                            $person['requirements']['past_due']);
                        
                        if (count($allRequirements)) {
                            Log::info('Person:');
                            Log::info($person);
                            Log::info($person['requirements']);
                            
                            $user = User::where('stripe_acct_id', $data['account'])->firstOrFail();
                            //$accountIdEncoded = base64_encode($data['account']);
                            //$personIdEncoded = base64_encode($person['id']);
                            $uploadLink = route('home') . '?login_modal=show&redirect_url=' . route('educator.update.stripe');
                            $personDetails = [
                                'name' => $person['first_name'] . ' ' . $person['last_name'],
                                'email' => $person['email']
                            ];
                            
                            $job = new  SendEmailJob($user->email, new StripeAccountError($user, $uploadLink,
                                $personDetails));
                            
                            $this->dispatch($job);
                        }
                    }
                }
            }
            
            // Account updated event
            if ($data['type'] == 'account.updated') {
                $account = $data['data']['object'];
                
                if ($account['business_type'] !== 'individual') {
                    Log::info('Account:');
                    Log::info($account);
                    Log::info($account['requirements']);
                    
                    
                    $allRequirements = array_merge($account['requirements']['currently_due'], $account['requirements']['past_due']);
                    
                    $accountRequirements = 0;
                    
                    // Check if requirement is for account only so we dont fire extra emails
                    foreach ($allRequirements as $requirement){
                        if(strpos($requirement, 'person_') === false){
                            $accountRequirements++;
                        }
                    }
                    
                    if ($accountRequirements) {
                        $user = User::where('stripe_acct_id', $data['account'])->firstOrFail();
                        //$accountIdEncoded = base64_encode($data['account']);
                        $uploadLink = route('home') . '?login_modal=show&redirect_url=' . route('educator.update.stripe');
                        $personDetails = [
                            'name' => $user->name,
                            'email' => $user->email
                        ];
                        
                        $job = new  SendEmailJob($user->email, new StripeAccountError($user, $uploadLink,
                            $personDetails));
                        
                        $this->dispatch($job);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
    
    public function reUploadDocuments(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'day' => 'required|numeric',
            'month' => 'required|numeric',
            'year' => 'required|numeric',
        ];
        
        $validateFields = ClassHubHelper::validateData($request->all(), $rules);
        
        if (is_array($validateFields)) {
            return redirect()->back()->withErrors($validateFields['messages']);
        }
        
        // Validate ID upload
        if ($request->file('front_photo') && $request->file('back_photo')) {
            $validateIds = ClassHubHelper::validateData($request->all(),
                [
                    'front_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                    'back_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120'
                ]);
        } else if ($request->file('front_photo')) {
            $validateIds = ClassHubHelper::validateData($request->all(),
                [
                    'front_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                ]);
        } else if ($request->file('back_photo')) {
            $validateIds = ClassHubHelper::validateData($request->all(),
                [
                    'back_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120'
                ]);
        } else {
            return redirect()->back()->withErrors(['Please upload document']);
        }
        
        if (is_array($validateIds)) {
            return redirect()->back()->withErrors($validateIds['messages']);
        }
        
        try {
            
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            
            $fp1 = $request->file('front_photo') ?
                fopen($request->file('front_photo')->path(), 'r') : null;
            $fp2 = $request->file('back_photo') ?
                fopen($request->file('back_photo')->path(), 'r') : null;
            
            $fileFront = $fp1 ? File::create([
                'purpose' => 'identity_document',
                'file' => $fp1
            ]) : null;
            
            $fileBack = $fp2 ? File::create([
                'purpose' => 'identity_document',
                'file' => $fp2
            ]) : null;
            
            Account::updatePerson(
                $request->stripe_acct_id,
                $request->person_id,
                [
                    'dob' => [
                        'day' => $request->day,
                        'month' => $request->month,
                        'year' => $request->year,
                    ],
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'verification' =>
                        ['document' =>
                            [
                                'front' => $fileFront ? $fileFront['id'] : '',
                                'back' => $fileBack ? $fileBack['id'] : ''
                            ]
                        ]
                ]
            );
            
            return redirect()->back()->with(['success' => ['Account updated successfully']]);
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }
    
    public function uploadAddlDocuments(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'day' => 'required|numeric',
            'month' => 'required|numeric',
            'year' => 'required|numeric',
        ];
        
        $validateFields = ClassHubHelper::validateData($request->all(), $rules);
        
        if (is_array($validateFields)) {
            return redirect()->back()->withErrors($validateFields['messages']);
        }
        
        // Validate ID upload
        if ($request->file('front_photo') && $request->file('back_photo')) {
            $validateIds = ClassHubHelper::validateData($request->all(),
                [
                    'front_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                    'back_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120'
                ]);
        } else if ($request->file('front_photo')) {
            $validateIds = ClassHubHelper::validateData($request->all(),
                [
                    'front_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                ]);
        } else if ($request->file('back_photo')) {
            $validateIds = ClassHubHelper::validateData($request->all(),
                [
                    'back_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120'
                ]);
        } else {
            return redirect()->back()->withErrors(['Please upload document']);
        }
        
        if (is_array($validateIds)) {
            return redirect()->back()->withErrors($validateIds['messages']);
        }
        
        try {
            
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            
            $fp1 = $request->file('front_photo') ?
                fopen($request->file('front_photo')->path(), 'r') : null;
            $fp2 = $request->file('back_photo') ?
                fopen($request->file('back_photo')->path(), 'r') : null;
            
            $fileFront = $fp1 ? File::create([
                'purpose' => 'identity_document',
                'file' => $fp1
            ]) : null;
            
            $fileBack = $fp2 ? File::create([
                'purpose' => 'identity_document',
                'file' => $fp2
            ]) : null;
            
            Account::updatePerson(
                $request->stripe_acct_id,
                $request->person_id,
                [
                    'dob' => [
                        'day' => $request->day,
                        'month' => $request->month,
                        'year' => $request->year,
                    ],
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'verification' =>
                        ['additional_document' =>
                            [
                                'front' => $fileFront ? $fileFront['id'] : '',
                                'back' => $fileBack ? $fileBack['id'] : ''
                            ]
                        ]
                ]
            );
            
            return redirect()->back()->with(['success' => ['Account updated successfully']]);
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }
    
    public function updateMcc(Request $request)
    {
        
        try {
            
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            
            Account::update(
                $request->stripe_acct_id,
                [
                    'business_profile' => [
                        'mcc' => $request->industry
                    ]
                
                ]
            );
            
            return redirect()->back()->with(['success' => ['Indutry updated successfully']]);
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }
    
    public function updateAccount(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
        $account = [
            'business_profile' => [
                'mcc' => $request->industry,
            ],
            'default_currency' => $request->currency,
            'email' => Auth::user()->email,
            'requested_capabilities' => [
                'card_payments',
                'transfers'
            ]
        ];
        
        try {
            
            if ($request->account_type == 'company') {
                if ($request->country_code && $request->business_phone_no) {
                    $account['company']['phone'] = $request->country_code . $request->business_phone_no;
                }
                
                Account::update(Auth::user()->stripe_acct_id, $account);
                
                $documents = $this->uploadPersonDocuments($request);
                
                $i = 0;
                foreach ($request->persons as $personId => $person) {
                    $personData = [
                        'address' => [
                            'line1' => $person['line1'],
                            'line2' => $person['line2'],
                            'postal_code' => $person['postal_code'],
                            'city' => $person['city'],
                            'state' => $person['state'],
                        ],
                        'dob' => [
                            'day' => $person['day'],
                            'month' => $person['month'],
                            'year' => $person['year'],
                        ],
                        'email' => $person['email'],
                        'first_name' => $person['first_name'],
                        'last_name' => $person['last_name'],
                        'relationship' => [
                            'title' => $person['title'],
                        ],
                        'verification' =>
                            [
                                'document' =>
                                    [
                                        'front' => isset($documents[$i]) ? (['front'] ? $documents[$i]['front']['id'] : '') : '',
                                        'back' => isset($documents[$i]) ? ($documents[$i]['back'] ? $documents[$i]['back']['id'] : '') : ''
                                    ]
                                ,
                                'additional_document' =>
                                    [
                                        'front' => isset($documents[$i]) ? ($documents[$i]['addl_front'] ? $documents[$i]['addl_front']['id'] : '') : '',
                                        'back' => isset($documents[$i]) ? ($documents[$i]['addl_back'] ? $documents[$i]['addl_back']['id'] : '') : ''
                                    ]
                            ]
                    ];
                    
                    Account::updatePerson(Auth::user()->stripe_acct_id, $personId, $personData);
                    
                    $i++;
                }
                
                return response()->json([
                    'status' => true,
                    'messages' => ['Account updated successfully']
                ]);
            } else {
                $fp1 = $request->file('front_photo') ?
                    fopen($request->file('front_photo')->path(), 'r') : null;
                
                $fp2 = $request->file('back_photo') ?
                    fopen($request->file('back_photo')->path(), 'r') : null;
                
                $fp3 = $request->file('addl_front_photo') ?
                    fopen($request->file('addl_front_photo')->path(), 'r') : null;
                
                $fp4 = $request->file('addl_back_photo') ?
                    fopen($request->file('addl_back_photo')->path(), 'r') : null;
                
                $fileFront = $fp1 ? File::create([
                    'purpose' => 'identity_document',
                    'file' => $fp1
                ]) : null;
                
                $fileBack = $fp2 ? File::create([
                    'purpose' => 'identity_document',
                    'file' => $fp2
                ]) : null;
                
                $addlFileFront = $fp3 ? File::create([
                    'purpose' => 'identity_document',
                    'file' => $fp3
                ]) : null;
                
                $addlFileBack = $fp4 ? File::create([
                    'purpose' => 'identity_document',
                    'file' => $fp4
                ]) : null;
                
                $personData = [
                    'individual' =>
                        [
                            'address' => [
                                'line1' => $request->line1,
                                'line2' => $request->line2,
                                'postal_code' => $request->postal_code,
                                'city' => $request->city,
                                'state' => $request->state,
                            ],
                            'dob' => [
                                'day' => $request->day,
                                'month' => $request->month,
                                'year' => $request->year,
                            ],
                            'email' => $request->email,
                            'first_name' => $request->first_name,
                            'last_name' => $request->last_name,
                            'verification' =>
                                [
                                    'document' =>
                                        [
                                            'front' => $fileFront ? $fileFront['id'] : '',
                                            'back' => $fileBack ? $fileBack['id'] : ''
                                        ]
                                    ,
                                    'additional_document' =>
                                        [
                                            'front' => $addlFileFront ? $addlFileFront['id'] : '',
                                            'back' => $addlFileBack ? $addlFileBack['id'] : ''
                                        ]
                                ]
                        ]
                ];
                
                Account::update(Auth::user()->stripe_acct_id, array_merge($account, $personData));
                
                return response()->json([
                    'status' => true,
                    'messages' => ['Account updated successfully']
                ]);
            }
        } catch (\Exception $e) {
            $stripeUnderAgeError = 'at least 13 years';
            $underAgeErrorMsg = 'Must be at least 18 years of age to use Stripe';
            $erroMessage = strpos($e->getMessage(), $stripeUnderAgeError) !== false ? $underAgeErrorMsg : $e->getMessage();
            
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $erroMessage],
                'errors' => $e->getTraceAsString()
            ]);
        }
        
    }
    
    public function uploadPersonDocuments($request)
    {
        $identityDocuments = [];
        
        if ($request->file('persons') === null) {
            return $identityDocuments;
        }
        
        foreach ($request->file('persons') as $id => $files) {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            
            $fp1 = isset($files['front_photo']) ?
                fopen($files['front_photo']->path(), 'r') : null;
            
            $fp2 = isset($files['back_photo']) ?
                fopen($files['back_photo']->path(), 'r') : null;
            
            $fp3 = isset($files['addl_front_photo']) ?
                fopen($files['addl_front_photo']->path(), 'r') : null;
            
            $fp4 = isset($files['add_back_photo']) ?
                fopen($files['addl_back_photo']->path(), 'r') : null;
            
            $fileFront = $fp1 ? File::create([
                'purpose' => 'identity_document',
                'file' => $fp1
            ]) : null;
            
            $fileBack = $fp2 ? File::create([
                'purpose' => 'identity_document',
                'file' => $fp2
            ]) : null;
            
            $addlFileFront = $fp3 ? File::create([
                'purpose' => 'identity_document',
                'file' => $fp3
            ]) : null;
            
            $addlFileBack = $fp4 ? File::create([
                'purpose' => 'identity_document',
                'file' => $fp4
            ]) : null;
            
            array_push($identityDocuments, ['front' => $fileFront, 'back' => $fileBack, 'addl_front' => $addlFileFront, 'addl_back' => $addlFileBack]);
            
        }
        
        return $identityDocuments;
    }
    
    public static function testPayout()
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
        $bookingClasses = BookingClass::with('booking')->where('status', 'completed')
            ->whereNull('transaction_id')->where('payout_amount', 0)->get();
        
        foreach ($bookingClasses as $bookingClass) {
            
            $booking = $bookingClass->booking;
            
            $classEndAt = Carbon::parse($bookingClass->class->date . ' ' . $bookingClass->class->end_time);
            
            if ($classEndAt->isFuture() || Carbon::now()->diffInHours($classEndAt, false) < 24)
                continue;
            
            $refundRequest = RefundRequest::where('booking_id', $booking->id)
                ->where('lesson_class_id', $bookingClass->class->id)->first();
            
            if ($refundRequest && ($refundRequest->has_been_payout || $refundRequest->in_progress)) {
                continue;
            }
            
            list($totalPayableAmount, $totalPayoutAmount) = self::getPayableAndPayoutDetails($booking);
            
            $amountPayablePerClass = ClassHubHelper::roundCents(($booking->amount - ($booking->application_fee +
                        $booking->stripe_fee)) / $booking->classes->count());
            
            dump('Paybale Amount: ', $totalPayableAmount);
            dump('Payout Amount: ', $totalPayoutAmount);
            $unpaidAmount = $totalPayableAmount - $totalPayoutAmount;
            dump('Amount to payout: ', $amountPayablePerClass);
            
            $amountPayablePerClass = $amountPayablePerClass > $unpaidAmount ? $unpaidAmount : $amountPayablePerClass;
            
            dump('Amount Unpaid: ', $unpaidAmount);
            dump('Amount to payout: ', $amountPayablePerClass);
            
            
            dump($classEndAt);
            
            $payout = null;
            
            $user = $booking->lesson->user;
            
            try {
                
                $payout = self::payout($user, $booking, $amountPayablePerClass, $bookingClass->class->id);
                
                DB::beginTransaction();
                
                $transaction = Transaction::create([
                    'booking_id' => $booking->id,
                    'txn_id' => $payout->id,
                    'amount' => $payout->amount,
                    'txn_details' => json_encode($payout),
                    'status' => $payout['status'],
                    'type' => $payout['object']
                ]);
                
                $bookingClass->update([
                    'transaction_id' => $transaction->id,
                    'payout_amount' => $payout->amount
                ]);
                
                DB::commit();
                
                dump($bookingClass);
                dump($payout);
                dump('payout');
                
            } catch (\Exception $e) {
                if ($payout) {
                    ErrorLog::create([
                        'user_id' => $user->id,
                        'type' => 'payout',
                        'data' => 'Booking ID: ' . $booking->id .
                            ', Class ID: ' . $bookingClass->lesson_class_id . ' /  Reason : ' . $e->getMessage(),
                        'details' => json_encode($payout),
                        'status' => 'failed'
                    ]);
                    
                    $payout->cancel();
                } else {
                    ErrorLog::create([
                        'user_id' => $user->id,
                        'type' => 'payout',
                        'data' => 'Booking ID: ' . $booking->id .
                            ', Class ID: ' . $bookingClass->lesson_class_id . ' / Reason : ' .
                            $e->getMessage(),
                        'details' => $e->getTraceAsString(),
                        'status' => 'failed'
                    ]);
                    
                }
            }
        }
        
    }
    
    public static function addFunds($user)
    {
        $token = Token::create([
            'card' => [
                'number' => '4000000000000077',
                'exp_month' => 7,
                'exp_year' => 2024,
                'cvc' => '314'
            ]
        ]);
        
        $charge = Charge::create([
            'amount' => 40000,
            'currency' => 'eur',
            'source' => $token,
            'description' => 'Topup'
        ], ['stripe_account' => $user->stripe_acct_id]);
    }
    
    public function stripeTopup(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
        try {
            
            $charge = Charge::create([
                'amount' => 200000,
                'currency' => 'eur',
                'source' => $request->stripeToken,
                'description' => 'Topup'
            ], ['stripe_account' => $request->stripe_account]);
            
            dd($charge);
        } catch (\Exception $e) {
            dd($e->getTrace());
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }
    
}
