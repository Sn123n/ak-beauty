<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Categories;
use App\Models\ProductReview;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'DESC')->get();
        return view('admin.product.manage_product', compact('products'));
    }

    public function create()
    {
        $categories = Categories::all();
        return view('admin.product.addproduct', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'sku' => 'required',
            'qnty' => 'required|integer',
            'price' => 'required',
            'image' => 'required|file|max:3048',
            'back_image' => 'nullable|file|max:3048',
            'other_image.*' => 'nullable|file|max:3048',
        ]);

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = strtolower($file->getClientOriginalExtension());
            
            if (!in_array($extension, $allowedExtensions)) {
                return redirect()->back()
                    ->withErrors(['image' => 'The image field must be a file of type: jpeg, png, jpg, gif.'])
                    ->withInput();
            }
            
            $imageName = time() . '.' . $extension;
            $file->move(public_path('product'), $imageName);
            $imagePath = $imageName;
        }

        $backImagePath = null;
        if ($request->hasFile('back_image')) {
            $file = $request->file('back_image');
            $extension = strtolower($file->getClientOriginalExtension());
            
            if (!in_array($extension, $allowedExtensions)) {
                return redirect()->back()
                    ->withErrors(['back_image' => 'The back image field must be a file of type: jpeg, png, jpg, gif.'])
                    ->withInput();
            }
            
            $backImageName = time() . '_back.' . $extension;
            $file->move(public_path('product'), $backImageName);
            $backImagePath = $backImageName;
        }

        $otherImagePaths = [];
        if ($request->hasFile('other_image')) {
            foreach ($request->file('other_image') as $image) {
                $extension = strtolower($image->getClientOriginalExtension());
                
                if (!in_array($extension, $allowedExtensions)) {
                    return redirect()->back()
                        ->withErrors(['other_image' => 'The other images must be files of type: jpeg, png, jpg, gif.'])
                        ->withInput();
                }
                
                $otherImageName = time() . uniqid() . '.' . $extension;
                $image->move(public_path('product'), $otherImageName);
                $otherImagePaths[] = $otherImageName;
            }
        }

        // Process variations
        $variations = [];
        if ($request->has('variations') && is_array($request->variations)) {
            $defaultVariation = $request->default_variation ?? 0;
            foreach ($request->variations as $index => $variation) {
                if (!empty($variation['name'])) {
                    $variations[] = [
                        'name' => $variation['name'],
                        'price' => !empty($variation['price']) ? $variation['price'] : null,
                        'sku' => !empty($variation['sku']) ? $variation['sku'] : null,
                        'stock' => !empty($variation['stock']) ? $variation['stock'] : 0,
                        'is_default' => ($index == $defaultVariation)
                    ];
                }
            }
        }

        $array = [
            'category_id' => $request->category_id,
            'title' => $request->title,
            'sku' => $request->sku,
            'qnty' => $request->qnty,
            'price' => $request->price,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'content' => $request->content,
            'daily_deal' => $request->daily_deal,
            'status' => $request->status,
            'image' => $imagePath,
            'back_image' => $backImagePath,
            'other_image' => json_encode($otherImagePaths),
            'variations' => !empty($variations) ? json_encode($variations) : null,
        ];
        Product::create($array);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $categories = Categories::all();
        $product = Product::findOrFail($id);
        return view('admin.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'sku' => 'required',
            'qnty' => 'required|integer',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'content' => 'nullable|string',
            'status' => 'nullable|integer',
            'image' => 'nullable|file|max:3048',
            'back_image' => 'nullable|file|max:3048',
            'other_image.*' => 'nullable|file|max:3048',
        ]);

        $product = Product::findOrFail($id);
        $imagePath = $product->image;
        $oldOtherImages = json_decode($product->other_image, true) ?? [];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = strtolower($file->getClientOriginalExtension());
            
            if (!in_array($extension, $allowedExtensions)) {
                return redirect()->back()
                    ->withErrors(['image' => 'The image field must be a file of type: jpeg, png, jpg, gif.'])
                    ->withInput();
            }
            
            $imageName = time() . '.' . $extension;
            $file->move(public_path('product'), $imageName);

            if ($product->image && file_exists(public_path('product/' . $product->image))) {
                unlink(public_path('product/' . $product->image));
            }
            $imagePath = $imageName;
        }

        $backImagePath = $product->back_image;
        if ($request->hasFile('back_image')) {
            $file = $request->file('back_image');
            $extension = strtolower($file->getClientOriginalExtension());
            
            if (!in_array($extension, $allowedExtensions)) {
                return redirect()->back()
                    ->withErrors(['back_image' => 'The back image field must be a file of type: jpeg, png, jpg, gif.'])
                    ->withInput();
            }
            
            $backImageName = time() . '_back.' . $extension;
            $file->move(public_path('product'), $backImageName);

            if ($product->back_image && file_exists(public_path('product/' . $product->back_image))) {
                unlink(public_path('product/' . $product->back_image));
            }
            $backImagePath = $backImageName;
        }

        $otherImagePaths = $oldOtherImages;

        if ($request->hasFile('other_image')) {
            foreach ($request->file('other_image') as $image) {
                $extension = strtolower($image->getClientOriginalExtension());
                
                if (!in_array($extension, $allowedExtensions)) {
                    return redirect()->back()
                        ->withErrors(['other_image' => 'The other images must be files of type: jpeg, png, jpg, gif.'])
                        ->withInput();
                }
                
                $otherImageName = time() . uniqid() . '.' . $extension;
                $image->move(public_path('product'), $otherImageName);
                $otherImagePaths[] = $otherImageName;
            }
        }

        // Process variations
        $variations = [];
        if ($request->has('variations') && is_array($request->variations)) {
            $defaultVariation = $request->default_variation ?? 0;
            foreach ($request->variations as $index => $variation) {
                if (!empty($variation['name'])) {
                    $variations[] = [
                        'name' => $variation['name'],
                        'price' => !empty($variation['price']) ? $variation['price'] : null,
                        'sku' => !empty($variation['sku']) ? $variation['sku'] : null,
                        'stock' => !empty($variation['stock']) ? $variation['stock'] : 0,
                        'is_default' => ($index == $defaultVariation)
                    ];
                }
            }
        }

        $data = [
            'category_id' => $request->category_id,
            'title' => $request->title,
            'sku' => $request->sku,
            'qnty' => $request->qnty,
            'price' => $request->price,
            'discount' => $request->discount,
            'content' => $request->content,
            'daily_deal' => $request->daily_deal,
            'discount_type' => $request->discount_type,
            'status' => $request->status,
            'image' => $imagePath,
            'back_image' => $backImagePath,
            'other_image' => json_encode($otherImagePaths),
            'variations' => !empty($variations) ? json_encode($variations) : null,
        ];
        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && file_exists(public_path('product/' . $product->image))) {
            unlink(public_path('product/' . $product->image));
        }
        if ($product->other_image) {
            $otherImages = json_decode($product->other_image, true);
            foreach ($otherImages as $image) {
                $imagePath = public_path('product/' . $image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }


    public function deleteImage(Request $request)
    {
        try {
            $product = Product::findOrFail($request->id);
            $imageToDelete = $request->image;

            if (!empty($product->other_image)) {
                $images = json_decode($product->other_image, true);

                if (($key = array_search($imageToDelete, $images)) !== false) {
                    unset($images[$key]);
                }
                $product->other_image = json_encode(array_values($images));
                $product->save();
                $imagePath = public_path('product/' . $imageToDelete);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
            }
            return response()->json(['success' => false, 'message' => 'No images found']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong']);
        }
    }


    public function updateDailyDealStatus(Request $request)
    {
        $product = Product::find($request->id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->daily_deal = $request->daily_deal;
        $product->save();

        return response()->json(['message' => 'Daily Deal status updated successfully']);
    }

    public function reviewlist()
    {
        $reviews = ProductReview::orderBy('id', 'DESC')->get();
        return view('admin.product.review', compact('reviews'));
    }

    public function reviewFilterList($id)
    {
        $reviews = ProductReview::where('product_id', $id)->orderBy('id', 'DESC')->get();
        return view('admin.product.review', compact('reviews'));
    }




    public function deletereview(ProductReview $review)
    {
        if ($review) {
            $review->delete();
            return redirect()->route('review.list')->with('success', 'Review deleted successfully.');
        }
        return redirect()->route('review.list')->with('error', 'Review not found.');
    }
}
