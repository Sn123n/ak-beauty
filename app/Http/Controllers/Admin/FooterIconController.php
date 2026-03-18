<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FooterIcon;

class FooterIconController extends Controller
{
    public function index()
    {
        $footers = FooterIcon::get();
        return view('admin.footer.index', compact('footers'));
    }
    public function create()
    {
        $footerIcon = null;
        return view('admin.footer.add', compact('footerIcon'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'detail' => 'required|string',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('/footericon'), $imageName);
        }

        FooterIcon::create([
            'title' => $request->title,
            'image' => $imageName,
            'detail' => $request->detail,
            'status' => $request->status,
        ]);

        return redirect()->route('footer-icon.index')->with('success', 'Footer Icon created successfully!');
    }

    public function edit($id)
    {
        $footerIcon = FooterIcon::where("id", $id)->first();
        // dd($footerIcon);
        return view('admin.footer.add', compact('footerIcon'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'detail' => 'required|string',
        ]);

        $footerIcon = FooterIcon::findOrFail($id);

        $imageName = $footerIcon->image;

        if ($request->hasFile('image')) {
            if ($imageName && file_exists(public_path('/footericon/' . $imageName))) {
                unlink(public_path('/footericon/' . $imageName));
            }

            // upload new image
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('/footericon'), $imageName);
        }

        $footerIcon->update([
            'title' => $request->title,
            'image' => $imageName,
            'detail' => $request->detail,
            'status' => $request->status,
        ]);

        return redirect()->route('footer-icon.index')->with('success', 'Footer Icon updated successfully!');
    }
}
