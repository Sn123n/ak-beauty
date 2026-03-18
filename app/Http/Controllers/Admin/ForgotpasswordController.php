<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ForgotpasswordController extends Controller
{
    public function chnagepass()
    {
        return view('admin.resetpassword.resetpassword');
    }

    public function resetPassword(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'old_password.required' => 'Old password is required.',
            'password.required' => 'New password is required.',
            'password.min' => 'New password must be at least 8 characters.',
            'password.confirmed' => 'New password and Confirm password must match.',
        ]);
        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Old password is incorrect.']);
        }
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        Auth::logout();
        return redirect()->route('login')->with('success', 'Password has been updated successfully.');
    }
}
