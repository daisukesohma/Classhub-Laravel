<?php

namespace App\Http\Controllers;

use App\Helpers\ClassHubHelper;
use App\Jobs\SendEmailJob;
use App\Mail\PasswordResetCode;
use App\PasswordReset;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function forgotPasswordPage()
    {
        return view('frontend.pages.password.forgot');
    }

    public function resetPasswordSentPage()
    {
        $email = session()->get('email');
        return view('frontend.pages.password.email-sent', compact('email'));
    }

    public function sendResetCodeEmail(Request $request)
    {
        try {
            $user = User::whereEmail($request->email)->first();

            if ($user) {
                $passwordReset = PasswordReset::create(['user_id' => $user->id, 'code' => uniqid()]);

                $job = new SendEmailJob($user->email, new PasswordResetCode($passwordReset, $user->email));

                $this->dispatch($job);

                if ($request->ajax()) {
                    return response()->json([
                        'status' => true,
                        'email' => $request->email
                    ]);
                }

                return redirect()->route('page.reset.password.sent')->with(['email' => $user->email]);

            } else {

                if ($request->ajax()) {
                    return response()->json([
                        'status' => false,
                        'messages' => [Lang::get('messages.email.not_found', ['email' => $request->email])]
                    ]);
                }

                return redirect()->back()->withErrors([Lang::get('messages.email.not_found',
                    ['email' => $request->email])]);
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => false,
                    'messages' => [Lang::get('messages.email.not_found', ['email' => $request->email])]
                ]);
            }

            return redirect()->back()->withErrors([Lang::get('messages.email.not_found',
                ['email' => $request->email])]);
        }
    }

    public function resetPasswordPage($userId, $code)
    {
        $expired = false;

        try {
            $passwordReset = PasswordReset::where('user_id', base64_decode($userId))
                ->where('code', base64_decode($code))->first();

            if ($passwordReset) {
                if (Carbon::now()->diffInHours(Carbon::parse($passwordReset->created_at), false) <= -24)
                    $expired = true;

                return view('frontend.pages.password.reset', compact('expired', 'passwordReset'));
            } else {
                return view('frontend.pages.password.reset', compact('expired'))
                    ->withErrors([Lang::get('messages.error')]);
            }
        } catch (\Exception $e) {
            return view('frontend.pages.password.reset', compact('expired'))
                ->withErrors([$e->getMessage()]);
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->except('user_id'), [
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages());
        }

        try {
            $user = User::findOrFail($request->user_id);

            $passwordReset = $user->passwordResets->last();

            if ($passwordReset && ($passwordReset->code === $request->reset_code)) {
                $user->update(['password' => Hash::make($request->password)]);
                $passwordReset->update(['completed' => 1]);

                return redirect()->back()->with(['success' => [Lang::get('messages.password.reset.success')]]);
            } else {
                return redirect()->back()->withErrors([Lang::get('messages.error')]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }
}
