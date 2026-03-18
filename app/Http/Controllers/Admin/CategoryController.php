<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function create()
    {
        return view('admin.category.addcategory');
    }
    public function index()
    {
        $categories = Categories::get();
        return view('admin.category.manage_category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|file|max:3048',
        ]);

        $imageName = null;
        $homeimageName = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = strtolower($file->getClientOriginalExtension());
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            // Manual extension check for Laragon compatibility
            if (!in_array($extension, $allowedExtensions)) {
                return redirect()->back()
                    ->withErrors(['image' => 'The image field must be a file of type: jpeg, png, jpg, gif.'])
                    ->withInput();
            }
            
            $imageName = time() . '.' . $extension;
            $file->move(public_path('/categories'), $imageName);
        }

        Categories::create([
            'name' => $request->name,
            'image' => $imageName,
            'content' => $request->content,
            'status' => $request->status,
            'display_on_home' => $request->display_on_home,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = Categories::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|file|max:3048',
        ]);

        $category = Categories::findOrFail($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = strtolower($file->getClientOriginalExtension());
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            // Manual extension check for Laragon compatibility
            if (!in_array($extension, $allowedExtensions)) {
                return redirect()->back()
                    ->withErrors(['image' => 'The image field must be a file of type: jpeg, png, jpg, gif.'])
                    ->withInput();
            }
            
            if ($category->image && file_exists(public_path('categories/' . $category->image))) {
                unlink(public_path('categories/' . $category->image));
            }

            $imageName = time() . '.' . $extension;
            $file->move(public_path('categories'), $imageName);

            $category->image = $imageName;
        }

        $category->name = $request->name;
        $category->content = $request->content;
        $category->status = $request->status;
        $category->display_on_home = $request->display_on_home;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Categories::find($id);
        // dd($id);
        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }
        $products = Product::where('category_id', $id)->get();
        foreach ($products as $product) {
            if ($product->image) {
                $productImagePath = public_path('product/' . $product->image);
                if (file_exists($productImagePath)) {
                    unlink($productImagePath);
                }
            }
            if ($product->other_image) {
                $otherImages = json_decode($product->other_image, true);
                if (!is_array($otherImages)) {
                    $otherImages = explode(',', $product->other_image);
                }
                foreach ($otherImages as $image) {
                    $otherImagePath = public_path('product/' . trim($image));
                    if (file_exists($otherImagePath)) {
                        unlink($otherImagePath);
                    }
                }
            }
        }
        Product::where('category_id', $id)->delete();
        if ($category->image) {
            $imagePath = public_path('categories/' . $category->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        if ($category->homeimage) {
            $homeimagePath = public_path('categories/' . $category->homeimage);
            if (file_exists($homeimagePath)) {
                unlink($homeimagePath);
            }
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category, its related products, and their images deleted successfully.');
    }



    public function updatedisplay_on_home (Request $request)
    {
        $product = Categories::find($request->id);
        if (!$product) {
            return response()->json(['message' => 'category not found'], 404);
        }

        $product->display_on_home = $request->display_on_home;
        $product->save();

        return response()->json(['message' => 'display on home  status updated successfully']);
    }

}
