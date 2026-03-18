<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;


class CouponController extends Controller
{
    public function index()
    {
        $data['coupon'] = Coupon::orderBy('created_at', 'desc')->get();
        return view('admin.coupon.index')->with($data);
    }    

 
    public function create()
    {   
        return view('admin.coupon.add');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'title' => 'required',
            'status' => 'required',
            'description' => 'required',
            'coupon_code' => 'required|unique:coupons,coupon_code',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date|after:start_date',
            'discount_type' => 'required|in:flat,percentage',
        ];
    
        if ($request->discount_type == 'percentage') {
            $rules['discount_percentage'] = 'required|numeric|min:0';
        } elseif ($request->discount_type == 'flat') {
            $rules['discount_rupees'] = 'required|numeric|min:0';
        }
    
        $validatedData = $request->validate($rules);

        $validatedData['discount_percentage'] = ($request->discount_type == 'percentage') ? $request->discount_percentage : null;
        $validatedData['discount_rupees'] = ($request->discount_type == 'flat') ? $request->discount_rupees : null;
    
        unset($validatedData['_token']); 
        Coupon::create($validatedData);
    
        return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');
    }
    

    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        $data['coupon_data'] = Coupon::where("id", $id)->first();
        return view('admin.coupon.add')->with($data);
    }

  
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $coupon = Coupon::findOrFail($id);
        // dd($coupon);
        $rules = [
            'title' => 'required',
            'status' => 'required',
            'coupon_code' => 'required|unique:coupons,coupon_code,' . $coupon->id,
            'start_date' => 'required|date',
            'expiry_date' => 'required|date|after:start_date',
        ];

        if ($request->discount_type == 'percentage') {
            $rules['discount_percentage'] = 'required';
        }

        if ($request->discount_type == 'flat') {
            $rules['discount_rupees'] = 'required';
        }
        
        $request->validate($rules);

        $post_data = $request->all();

        if($post_data['discount_type'] == 'flat'){
            $post_data['discount_percentage'] = null;
        }

        if($post_data['discount_type'] == 'percentage'){
            $post_data['discount_rupees'] = null;
        }

        $update_data = [
            'title' => $post_data['title'],
            'coupon_code' => $post_data['coupon_code'],
            'description' => $post_data['description'],
            'discount_type' => $post_data['discount_type'],
            'discount_rupees' => $post_data['discount_rupees'],
            'discount_percentage' => $post_data['discount_percentage'],
            'start_date' => $post_data['start_date'],
            'expiry_date' => $post_data['expiry_date'],
            'status' => $post_data['status'],
        ];
// dd($update_data);
        $update = Coupon::where('id',$id)->update($update_data);

        if($update){
            return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function destroy(string $id)
    {
        $coupon = Coupon::where('id', $id)->delete();
        
        if ($coupon) {
            return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully');
        } else {
            return back()->withErrors(['error' => 'Coupon not found']);
        }
    }
}
