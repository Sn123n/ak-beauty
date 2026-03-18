<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\forgetPasswordMail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class UserForgotPasswordController extends Controller
{


    public function forgot_password()
    {
        $password = DB::table('banners')->where('name', 'password')->first();

        $seoData = getSeo('user_forgot_password_link');
        $meta_title = $seoData['meta_title'] ?? '';
        $meta_keywords = $seoData['meta_keywords'] ?? '';
        $meta_description = $seoData['meta_description'] ?? '';

        return view('front.forgot_password.forgot_email', compact('password', 'meta_title', 'meta_keywords', 'meta_description'));
    }


    // public function forgot_password_check(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email'
    //     ]);

    //     $email = $request->email;

    //     if (User::where('email', $email)->exists()) {
    //         $user = User::where('email', $email)->first();
    //         $encrypted_user_id = Crypt::encrypt($user->id);
    //         $reset_password_link = route('reset_password', $encrypted_user_id);
    //         Mail::to($email)->send(new forgetPasswordMail($reset_password_link, $user));

    //         $user = User::where('email', $email)->update(['password_reset' => null]);

    //         return back()->with('success', 'Password reset link has been sent to your email.');
    //     } else {
    //         return back()->withErrors(['email' => 'Invalid email.']);
    //     }
    // }

    // public function forgot_password_check(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email:rfc,dns',
    //     ]);

    //     $email = $request->email;

    //     if (User::where('email', $email)->exists()) {
    //         $user = User::where('email', $email)->first();
    //         $encrypted_user_id = Crypt::encrypt($user->id);
    //         $reset_password_link = route('reset_password', $encrypted_user_id);


    //         $emailContent = View::make('front.emails.forgot_password', [
    //             'reset_password_link' => $reset_password_link,
    //             'user_data' => $user,
    //         ])->render();

    //         sendRegistrationEmail($email, 'Reset Password', $emailContent);

    //         User::where('email', $email)->update(['password_reset' => null]);

    //         return back()->with('success', 'Password reset link has been sent to your email.');
    //     } else {
    //         return back()->withErrors(['email' => 'Invalid email.']);
    //     }
    // }

    public function forgot_password_check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if ($user) {
            $encrypted_user_id = Crypt::encrypt($user->id);
            $reset_password_link = route('reset_password', $encrypted_user_id);

            $emailContent = View::make('front.emails.forgot_password', [
                'reset_password_link' => $reset_password_link,
                'user_data' => $user,
            ])->render();

            sendRegistrationEmail($email, 'Reset Password', $emailContent);
            User::where('email', $email)->update(['password_reset' => null]);

            return response()->json([
                'code' => 200,
                'success' => 'Password reset link has been sent to your email.'
            ]);
        } else {
            return response()->json([
                'errors' => [
                    'email' => ['This email is not signed up with us.']
                ]
            ], 422);
        }
    }


    public function reset_password($id)
    {
        $decrypted_user_id = Crypt::decrypt($id);
        $password_reset = User::where('id', $decrypted_user_id)->value('password_reset');
        if ($password_reset == "yes") {
            return redirect()->route('user.login')->with('error', 'Reset password link has been expired.');
        }
        $password = DB::table('banners')->where('name', 'password')->first();
        $seoData = getSeo('user_forgot_password');
        $meta_title = $seoData['meta_title'] ?? '';
        $meta_keywords = $seoData['meta_keywords'] ?? '';
        $meta_description = $seoData['meta_description'] ?? '';

        return view('front.forgot_password.forgot_password_link', compact(
            'password',
            'meta_title',
            'meta_keywords',
            'meta_description'
        ))->with(['user_id' => $decrypted_user_id]);
    }

    public function reset_password_check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $user_id = $request->user_id;
        $password = Hash::make($request->password);
    
        $user = User::find($user_id);
    
        if ($user) {
            $user->password = $password;
            $user->password_reset = 'yes';
            $user->save();
    
            return response()->json([
                'code' => 200,
                'redirect' => route('user.login'),
                'success' => 'Password has been reset successfully.'
            ]);
        } else {
            return response()->json([
                'errors' => [
                    'invalid' => ['Something went wrong!']
                ]
            ], 422);
        }
    }
    
}
