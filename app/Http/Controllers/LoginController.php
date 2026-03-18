<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RegisterSlider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.dashboard');
        }
        $seoData = getSeo('user_login');
        $meta_title = $seoData['meta_title'] ?? '';
        $meta_keywords = $seoData['meta_keywords'] ?? '';
        $meta_description = $seoData['meta_description'] ?? '';
        return view('front.layouts.login', compact('meta_title', 'meta_keywords', 'meta_description'));
    }

    public function register()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.dashboard');
        }
        $seoData = getSeo('user_register');
        $meta_title = $seoData['meta_title'] ?? '';
        $meta_keywords = $seoData['meta_keywords'] ?? '';
        $meta_description = $seoData['meta_description'] ?? '';
        return view('front.layouts.register', compact('meta_title', 'meta_keywords', 'meta_description'));
    }


    public function check_login(Request $request)
    {
        // Manually validate and return JSON response
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            if (Auth::user()->role_id == 2) {
                return response()->json([
                    'code' => 200,
                    'redirect_url' => route('user.dashboard')
                ]);
            } else {
                Auth::logout();
                return response()->json([
                    'errors' => ['invalid' => ['Access denied. Only authorized users can log in.']]
                ], 403);
            }
        }

        return response()->json([
            'errors' => ['invalid' => ['Invalid email or password']]
        ], 401);
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); // logout only web
        $request->session()->regenerate(); // optional, avoid full invalidation
        return redirect()->route('user.login');
    }


    public function sendLoginOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $email = $request->email;
        $userExists = User::where('email', $email)->where('role_id', 2)->exists();

        // Generate OTP
        $otp = rand(10000, 99999);
        $expiresAt = now()->addMinutes(5);

        // Store in session
        session()->put('login_otp', $otp);
        session()->put('login_otp_expires_at', $expiresAt);
        session()->put('login_email', $email);
        session()->put('user_exists', $userExists);

        \Log::info("Login OTP stored: " . $otp . " for email: " . $email . " (user exists: " . ($userExists ? 'yes' : 'no') . ")");

        // Send OTP email
        $otpContent = View::make('email.otp', [
            'otp' => $otp,
            'name' => $userExists ? User::where('email', $email)->first()->name : 'User',
        ])->render();

        sendRegistrationEmail($email, 'Your Login OTP Code', $otpContent);

        return response()->json([
            'code' => 200,
            'message' => 'OTP sent successfully to your email',
            'user_exists' => $userExists
        ]);
    }

    public function verifyLoginOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $sessionOtp = session('login_otp');
        $otpExpiresAt = session('login_otp_expires_at');
        $email = session('login_email');
        $userExists = session('user_exists');

        if (!$otpExpiresAt || now()->greaterThan($otpExpiresAt)) {
            return response()->json([
                'code' => 400,
                'message' => 'OTP expired, please request a new one.'
            ], 400);
        }

        if ($request->otp != $sessionOtp) {
            return response()->json([
                'code' => 400,
                'message' => 'Invalid OTP'
            ], 400);
        }

        // If user exists, login
        if ($userExists) {
            $user = User::where('email', $email)->where('role_id', 2)->first();
            if ($user) {
                Auth::login($user);
                session()->forget(['login_otp', 'login_otp_expires_at', 'login_email', 'user_exists']);

                return response()->json([
                    'code' => 200,
                    'message' => 'Login successful',
                    'redirect_url' => route('user.dashboard')
                ]);
            }
        } else {
            // User doesn't exist, auto-create and login
            $user = User::create([
                'email' => $email,
                'name' => explode('@', $email)[0], // Use email prefix as default name
                'password' => bcrypt(rand(100000, 999999)), // Random password
                'phone' => '',
                'role_id' => 2,
                'otp' => $sessionOtp,
            ]);

            Auth::login($user);
            session()->forget(['login_otp', 'login_otp_expires_at', 'login_email', 'user_exists']);

            return response()->json([
                'code' => 200,
                'message' => 'Account created and logged in successfully',
                'redirect_url' => route('user.dashboard')
            ]);
        }

        return response()->json([
            'code' => 400,
            'message' => 'Something went wrong'
        ], 400);
    }
}
