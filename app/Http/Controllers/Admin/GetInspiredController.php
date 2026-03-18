<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GetInspired;
use App\Models\Product;

class GetInspiredController extends Controller
{


    public function create()
    {
        $deal = GetInspired::first();
        return view('admin.getinspired.add', compact('deal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'detail' => 'required',
            'title' => 'required',
        ]);

        $deal = GetInspired::first();

        $imageName = $deal ? $deal->image : null;

        if ($request->hasFile('image')) {
            if ($imageName && file_exists(public_path('/dealday/' . $imageName))) {
                unlink(public_path('/dealday/' . $imageName));
            }
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('/dealday'), $imageName);
        }

        if ($deal) {
            $deal->update([
                'title' => $request->title,
                'detail' => $request->detail,
                'image' => $imageName,
                'status' => $request->status,
            ]);
            $message = 'Get Inspired updated successfully!';
        } else {
            GetInspired::create([
                'title' => $request->title,
                'detail' => $request->detail,
                'image' => $imageName,
                'status' => $request->status,
            ]);
            $message = 'Get Inspired added successfully!';
        }

        return redirect()->route('get-inspired.create')->with('success', $message);
    }

    public function getProducts($category_id)
    {
        $products = Product::where('category_id', $category_id)->where('status', 1)->get();
        return response()->json($products);
    }
}

