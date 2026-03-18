<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Location;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', '!=', 1)->orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        $countries = Location::where('location_type', 0)->where('status', 0)->get();
        $states = Location::where('location_type', 1)->where('status', 0)->get();
        $cities = Location::where('location_type', 2)->where('status', 0)->get();
        return view('admin.users.add', compact('countries', 'states', 'cities'));
    }
    public function store(Request $request)
    {

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('/user'), $imageName);
        }
        $role_id = $request->has('role_id') ? $request->role_id : 2;
        User::create([
            'name' => $request->name,
            'image' => $imageName,
            'email' => $request->email,
            'password' => $request->password,
            'address' => $request->address,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'pincode' => $request->pincode,
            'status' => $request->status,
            'role_id' => $role_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $countries = Location::where('location_type', 0)->where('status', 0)->get();
        $selectedCountry = $user->country;
        $selectedState   = $user->state;
        $selectedCity    = $user->city;

        return view('admin.users.edit', compact('user', 'countries', 'selectedCountry', 'selectedState', 'selectedCity'));
    }


    // public function update(Request $request, $id)
    // {
    //     dd($request->all());
    //     $user = User::findOrFail($id);

    //     $request->validate(
    //         [
    //             'email' => 'required|email|unique:users,email,' . $id,
    //             'password' => 'nullable|min:8',
    //             'name' => 'required|string|max:255',
    //             'phone' => [
    //                 'required',
    //                 'regex:/^[0-9]\d{9}$/',
    //                 'digits:10'
    //             ],
    //             'address' => 'required|string',
    //             'country' => 'required|string',
    //             'state' => 'required|string',
    //             'city' => 'required|string',
    //             'pincode' => 'required|numeric',
    //             'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    //         ],
    //         [
    //             'phone.regex' => 'Please enter a valid 10-digit mobile number.',
    //             'phone.digits' => 'Phone number must be exactly 10 digits.',
    //             'email.unique' => 'This email is already in use.',
    //             'password.min' => 'Password must be at least 8 characters long.',
    //         ],
    //     );

    //     $imageName = $user->image;

    //     if ($request->hasFile('image')) {
    //         // Delete old image if exists
    //         $oldImagePath = public_path('user/' . $user->image);
    //         if ($user->image && file_exists($oldImagePath)) {
    //             unlink($oldImagePath);
    //         }

    //         // Upload new image
    //         $imageName = time() . '.' . $request->image->getClientOriginalExtension();
    //         $request->image->move(public_path('user'), $imageName);
    //     }

    //     $user->update([
    //         'name' => $request->name,
    //         'lastname' => $request->lastname,
    //         'image' => $imageName,
    //         'email' => $request->email,
    //         'password' => $request->password ? bcrypt($request->password) : $user->password,
    //         'address' => $request->address,
    //         'phone' => $request->phone,
    //         'gender' => $request->gender,
    //         'dob' => $request->dob,
    //         'country' => $request->country,
    //         'state' => $request->state,
    //         'city' => $request->city,
    //         'pincode' => $request->pincode,
    //         'status' => $request->status,
    //         'role_id' => $request->has('role_id') ? $request->role_id : $user->role_id,
    //     ]);

    //     return redirect()->back()->with('success', 'User updated successfully!');
    // }


    public function update(Request $request, $id)
    {
        // dd($request->all());
        $user = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^[0-9]\d{9}$/', 'digits:10'],
            'address' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'pincode' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'phone.regex' => 'Please enter a valid 10-digit mobile number.',
            'phone.digits' => 'Phone number must be exactly 10 digits.',
            'email.unique' => 'This email is already in use.',
            'password.min' => 'Password must be at least 8 characters long.',
        ]);

        $imageName = $request->old_image; // Keep the old image by default

        if ($request->hasFile('image')) {
            if ($user->image && file_exists(public_path('user/' . $user->image))) {
                unlink(public_path('user/' . $user->image));
            }
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('user'), $imageName);
        }

        $user->update([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'image' => $imageName,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'address' => $request->address,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'pincode' => $request->pincode,
            'status' => $request->status,
            'role_id' => $request->has('role_id') ? $request->role_id : $user->role_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }


    public function destroy(User $user)
    {
        if ($user->image) {
            $imagePath = public_path('user/' . $user->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }
}
