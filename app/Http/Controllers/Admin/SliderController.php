<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::get();
        return view('admin.slider.index', compact('sliders'));
    }
    public function create()
    {
        return view('admin.slider.add');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('/slider'), $imageName);
        }

        Slider::create([
            'name' => $request->name,
            'image' => $imageName,
            'content' => $request->content,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'status' => $request->status,
        ]);

        return redirect()->route('sliders.index')->with('success', 'Slider created successfully!');
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $slider = Slider::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($slider->image && file_exists(public_path('slider/' . $slider->image))) {
                unlink(public_path('slider/' . $slider->image));
            }

            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('slider'), $imageName);

            $slider->image = $imageName;
        }

        $slider->name = $request->name;
        $slider->content = $request->content;
        $slider->button_text = $request->button_text;
        $slider->button_link = $request->button_link;
        $slider->status = $request->status;
        $slider->save();

        return redirect()->route('sliders.index')->with('success', 'Slider updated successfully!');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            $imagePath = public_path('slider/' . $slider->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $slider->delete();

        return redirect()->route('sliders.index')->with('success', 'Slider deleted successfully.');
    }

    public function updateStatus(Request $request)
    {
        try {
            $category = Slider::findOrFail($request->id);
            $category->status = $request->status;
            $category->save();

            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating status'], 500);
        }
    }
}
