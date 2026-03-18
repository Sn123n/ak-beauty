<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use App\Mail\OtpMail;
use App\Mail\RegisterMail;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;


class OtpController extends Controller
{

    public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();

        return response()->json(['exists' => $exists]);
    }


    // public function sendOtp(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|min:3|max:50',
    //         'email' => 'required|email|unique:users,email',
    //         'phone' => 'required|digits:10',
    //         'password' => 'required|string|min:6|confirmed',
    //         'password_confirmation' => 'required|string|min:6'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $otp = rand(10000, 99999);
    //     $expiresAt = now()->addMinute(); // OTP expires in 1 minute

    //     // Store OTP and expiry in session
    //     session()->put('otp', $otp);
    //     session()->put('otp_expires_at', $expiresAt);
    //     session()->put('email', $request->email);
    //     session()->put('name', $request->name);
    //     session()->put('phone', $request->phone);
    //     session()->put('password', bcrypt($request->password));

    //     \Log::info("OTP stored in session: " . session('otp') . " (expires at: $expiresAt)");

    //   $data=  Mail::to($request->email)->send(new OtpMail($otp, $request->name));

    //     return response([
    //         "code" => 200,
    //         "message" => "OTP sent successfully",
    //     ]);
    // }
    public function sendOtp(Request $request)
    {
        // Check if email is already verified from login
        $email = $request->email ?? session('register_email');
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:50',
            'email' => session('register_otp_verified') ? 'nullable' : 'required|email:rfc,dns|unique:users,email',
            'phone' => 'required|digits:10',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Use verified email from session if available
        if (session('register_otp_verified') && session('register_email')) {
            $email = session('register_email');
            // Check if email already exists (should not happen, but safety check)
            if (User::where('email', $email)->exists()) {
                return response()->json(['errors' => ['email' => ['This email is already registered']]], 422);
            }
        }

        // Generate OTP
        $otp = rand(10000, 99999);
        $expiresAt = now()->addMinute();

        // Store in session
        session()->put('otp', $otp);
        session()->put('otp_expires_at', $expiresAt);
        session()->put('email', $email);
        session()->put('name', $request->name);
        session()->put('phone', $request->phone);
        session()->put('password', bcrypt($request->password));

        \Log::info("OTP stored in session: " . session('otp') . " (expires at: $expiresAt)");

        $otpContent = View::make('email.otp', [
            'otp' => $otp,
            'name' => $request->name,
        ])->render();

        sendRegistrationEmail($email, 'Your OTP Code', $otpContent);

        return response([
            "code" => 200,
            "message" => "OTP sent successfully",
        ]);
    }



    // public function verifyOtpAndRegister(Request $request)
    // {
    //     \Log::info("Received OTP: " . $request->otp);
    //     \Log::info("Session OTP: " . session('otp'));

    //     $request->validate([
    //         'otp' => 'required|digits:5',
    //     ]);

    //     $sessionOtp = session('otp');
    //     $otpExpiresAt = session('otp_expires_at');

    //     if (!$otpExpiresAt || now()->greaterThan($otpExpiresAt)) {
    //         return response([
    //             "code" => 400,
    //             "message" => "OTP expired, please request a new one.",
    //         ]);
    //     }
    //     if ($request->otp != $sessionOtp) {
    //         return response([
    //             "code" => 400,
    //             "message" => "Invalid OTP",
    //         ]);
    //     }

    //     $user = User::create([
    //         'email' => session('email'),
    //         'name' => session('name'),
    //         'password' => session('password'),
    //         'phone' => session('phone'),
    //         'role_id' => 2,
    //         'otp' => $sessionOtp,
    //     ]);

    //     Mail::to($user->email)->send(new RegisterMail($user));

    //     session()->forget(['otp', 'otp_expires_at', 'email', 'name', 'password', 'phone']);
    //     Auth::login($user);

    //     return response([
    //         "code" => 200,
    //         "message" => "User registered successfully",
    //         "user" => $user
    //     ]);
    // }


    public function verifyOtpAndRegister(Request $request)
    {
        \Log::info("Received OTP: " . $request->otp);
        \Log::info("Session OTP: " . session('otp'));
    
        $request->validate([
            'otp' => 'required|digits:5',
        ]);
    
        $sessionOtp = session('otp');
        $otpExpiresAt = session('otp_expires_at');
    
        if (!$otpExpiresAt || now()->greaterThan($otpExpiresAt)) {
            return response([
                "code" => 400,
                "message" => "OTP expired, please request a new one.",
            ]);
        }
    
        if ($request->otp != $sessionOtp) {
            return response([
                "code" => 400,
                "message" => "Invalid OTP",
            ]);
        }
    
        $user = User::create([
            'email' => session('email'),
            'name' => session('name'),
            'password' => session('password'),
            'phone' => session('phone'),
            'role_id' => 2,
            'otp' => $sessionOtp,
        ]);

      $not=  Notification::create([
            'user_id' => $user->id,
            'type' => 'new_registered_user',
            'status' => 0, 
        ]);

        $emailContent = View::make('front.emails.welcome', [
            'user' => $user
        ])->render();
    
        sendRegistrationEmail($user->email, 'Registration Successful', $emailContent);
    
        // Clear session
        session()->forget(['otp', 'otp_expires_at', 'email', 'name', 'password', 'phone']);
        Auth::login($user);
    
        return response([
            "code" => 200,
            "message" => "User registered successfully",
            "user" => $user
        ]);
    }
    
}
