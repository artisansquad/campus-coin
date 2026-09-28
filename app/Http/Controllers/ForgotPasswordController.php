<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{

public function showForgotForm()
{
    return view('auth.forgetpassword');
}


public function showVerifyForm()
{
    return view('auth.verify-otp');
}

public function verifyOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp' => 'required'
    ]);

    $record = DB::table('password_reset_otps')
        ->where('email', $request->email)
        ->where('otp', $request->otp)
        ->first();

    if (!$record) {
        return back()->withErrors([
            'otp' => 'Invalid OTP.'
        ]);
    }

    if (now()->greaterThan($record->expires_at)) {

        DB::table('password_reset_otps')
            ->where('email', $request->email)
            ->delete();

        return back()->withErrors([
            'otp' => 'OTP has expired. Please request a new OTP.'
        ]);
    }

    // Mark OTP as verified and redirect to password reset
    return redirect()
        ->route('password.reset', ['email' => $request->email, 'otp' => $request->otp])
        ->with('success', 'OTP verified successfully! Please set your new password.');
}


    /**
     * Send OTP to email
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email not found.'
            ]);
        }

        $otp = rand(100000, 999999);

        DB::table('password_reset_otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
try {
     Mail::raw(
         "Your Campus Coin password reset OTP is: {$otp}",
         function ($message) use ($request) {
             $message->to($request->email)
                     ->subject('Campus Coin Password Reset OTP');
         }
     );
} catch (\Exception $e) {
    dd($e->getMessage());
}

      return redirect()
    ->route('password.verify.form')
    ->with('reset_email', $request->email)
    ->with('success', 'OTP sent to your email. Check your Gmail inbox.');
    }

    /**
     * Verify OTP and reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_otps')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        // if (!$record) {
        //     return back()->withErrors([
        //         'otp' => 'Invalid OTP.'
        //     ]);
        // }

        if (now()->greaterThan($record->expires_at)) {

            DB::table('password_reset_otps')
                ->where('email', $request->email)
                ->delete();

            return back()->withErrors([
                'otp' => 'OTP has expired. Please request a new OTP.'
            ]);
        }

        User::where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password)
            ]);

        DB::table('password_reset_otps')
            ->where('email', $request->email)
            ->delete();

        return redirect()
            ->route('login')
            ->with('success', 'Password updated successfully.');
    }
}




