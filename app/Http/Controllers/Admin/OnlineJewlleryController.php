<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jewellery;

class OnlineJewlleryController extends Controller
{
    public function create()
    {
        $jewellery = Jewellery::first();
        return view('admin.jewellery.add', compact('jewellery'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'title2' => 'required|string|max:255',
            'content' => 'required|string',
            'content2' => 'required|string',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // allow both image and video for image2
            'image2' => 'nullable|mimes:jpeg,png,jpg,gif,mp4,mov,avi,webm|max:10240', // 10MB max
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_1.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('/jewellry'), $imageName);
        }

        $fileName2 = null;
        if ($request->hasFile('image2')) {
            $fileName2 = time() . '_2.' . $request->image2->getClientOriginalExtension();
            $request->image2->move(public_path('/jewellry'), $fileName2);
        }

        $jewellery = Jewellery::first();

        if ($jewellery) {
            $jewellery->update([
                'title' => $request->title,
                'title2' => $request->title2,
                'button_text' => $request->button_text,
                'button_link' => $request->button_link,
                'image' => $imageName ?? $jewellery->image,
                'image2' => $fileName2 ?? $jewellery->image2,
                'content' => $request->content,
                'content2' => $request->content2,
                'status' => 1,
            ]);
        } else {
            Jewellery::create([
                'title' => $request->title,
                'title2' => $request->title2,
                'button_text' => $request->button_text,
                'button_link' => $request->button_link,
                'image' => $imageName,
                'image2' => $fileName2,
                'content' => $request->content,
                'content2' => $request->content2,
                'status' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Jewellery updated successfully!');
    }
}
