<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\User;
use App\Mail\SendOtpMail;
use App\Models\PasswordOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class PasswordResetLinkController extends Controller
{
    public function showForgotPassword(): View
    {
        return view('shared.forgot-password');
    }

    public function showVerifyCode(): View
    {
        return view('shared.verification-code');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No account found with that email.'
                ]);
            }
            return back()->withErrors(['email' => 'No account found with that email.']);
        }

        // Generate OTP and save hashed version
        $otp = rand(1000, 9999);
        $otpHash = Hash::make($otp);

        PasswordOtp::updateOrCreate(
            ['email' => $user->email],
            ['otp_hash' => $otpHash, 'expires_at' => now()->addMinutes(10)]
        );

        // Send OTP via Brevo HTTP API
        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'api-key' => env('BREVO_API_KEY'),
                'Content-Type' => 'application/json'
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => [
                    'name' => env('MAIL_FROM_NAME'),
                    'email' => env('MAIL_FROM_ADDRESS')
                ],
                'to' => [
                    ['email' => $user->email, 'name' => $user->name ?? $user->email]
                ],
                'subject' => 'Your OTP Code',
                'htmlContent' => "<p>Your OTP code is: <strong>{$otp}</strong></p>"
            ]);

            \Log::info('Brevo response status: ' . $response->status());
            \Log::info('Brevo response body: ' . $response->body());


            if (!$response->successful()) {
                return back()->withErrors([
                    'email' => 'Failed to send OTP. Please check your Brevo API key or try again later.'
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Brevo request failed: ' . $e->getMessage());
            return back()->withErrors([
                'email' => 'Failed to send OTP. Please try again later.'
            ]);
        }

        // Save email to session
        session(['email' => $user->email]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Verification code sent!'
            ]);
        }

        return redirect()->route('verification.form')->with('email', $user->email);
    }

    public function showVerificationForm()
    {
        return view('shared.verification-code', ['email' => session('email')]);
    }

    public function verifyOtp(Request $request)
    {
        if (!$request->filled('email') && session()->has('email')) {
            $request->merge(['email' => session('email')]);
        }

        $email = $request->input('email');
        if (is_array($email)) {
            $email = $email[0];
        }
        $request->merge(['email' => (string) $email]);

        $otp = $request->input('otp');
        if (is_array($otp)) {
            $otp = implode('', $otp);
        }
        $request->merge(['otp' => (string) $otp]);

        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:4',
        ]);

        $otpRecord = PasswordOtp::where('email', $email)->first();
        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'OTP not found.']);
        }
        if ($otpRecord->isExpired()) {
            return back()->withErrors(['otp' => 'OTP has expired.']);
        }
        if (!Hash::check($request->otp, $otpRecord->otp_hash)) {
            return back()->withErrors(['otp' => 'Invalid OTP.'])->withInput();
        }

        return redirect()->route('password.new')->with('email', $email);

        session(['email' => $email]);

        return redirect()->route('password.new')->with('email', $email);
    }

    public function showNewPasswordForm()
    {
        return view('shared.new-password', ['email' => session('email')]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        $user->update(['password' => Hash::make($request->password)]);
        PasswordOtp::where('email', $user->email)->delete();

        $redirectRoute = $user->role === 'admin' ? route('admin.login') : route('alumni.login');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset successful!',
                'redirect_to' => $redirectRoute
            ]);
        }

        session(['redirect_to' => $user->role === 'admin' ? 'admin.login' : 'alumni.login']);

        return redirect()->route($user->role === 'admin' ? 'admin.login' : 'alumni.login')
            ->with('success', 'Password reset successful!');
    }
}
