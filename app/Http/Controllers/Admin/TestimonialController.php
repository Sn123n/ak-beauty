<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::get();
        return view('admin.testimonial.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonial.add');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'address' => 'required|string',

        ]);

        Testimonial::create([
            'name' => $request->name,
            'address' => $request->address,
            'content' => $request->content,
            'status' => $request->status,
        ]);

        return redirect()->route('testimonial.index')->with('success', 'Testimonial created successfully!');
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonial.edit', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'address' => 'required|string',
        ]);

        $Testimonial = Testimonial::findOrFail($id);

        $Testimonial->name = $request->name;
        $Testimonial->content = $request->content;
        $Testimonial->address = $request->address;
        $Testimonial->status = $request->status;
        $Testimonial->save();

        return redirect()->route('testimonial.index')->with('success', 'Testimonial updated successfully!');
    }

    public function destroy(Testimonial $Testimonial)
    {

        $Testimonial->delete();

        return redirect()->route('testimonial.index')->with('success', 'Testimonial deleted successfully.');
    }
    public function updateStatus(Request $request)
    {
        try {
            $category = Testimonial::findOrFail($request->id);
            $category->status = $request->status;
            $category->save();

            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating status'], 500);
        }
    }
}
