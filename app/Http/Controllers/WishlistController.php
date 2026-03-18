<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductWishlist;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('user.login');
        }
        $wishlists = ProductWishlist::with('product')->where('user_id', Auth::id())->get();
        $wishlistbnner = DB::table('banners')->where('name', 'wishlist')->first();

        $seoData = getSeo('user_wishlist');
        $meta_title = $seoData['meta_title'] ?? '';
        $meta_keywords = $seoData['meta_keywords'] ?? '';
        $meta_description = $seoData['meta_description'] ?? '';

        return view('front.product.wishlist', compact('wishlists', 'wishlistbnner', 'meta_title', 'meta_keywords', 'meta_description'));
    }


    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Please log in to add to wishlist'], 401);
        }

        $user = Auth::user();
        $product_id = $request->product_id;

        $wishlistItem = ProductWishlist::where('user_id', $user->id)
            ->where('product_id', $product_id)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return response()->json(['message' => 'Removed from wishlist', 'status' => 'removed']);
        } else {
            ProductWishlist::create([
                'user_id' => $user->id,
                'product_id' => $product_id,
            ]);
            return response()->json(['message' => 'Product added to wishlist successfully', 'status' => 'added']);
        }
    }

    public function destroy(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Please log in to remove from wishlist'], 401);
        }

        $wishlist = null;

        // Try by wishlist_id first
        if ($request->has('wishlist_id')) {
            $wishlist = ProductWishlist::where('id', $request->wishlist_id)
                ->where('user_id', Auth::id())
                ->first();
        }

        // If not found, try by product_id
        if (!$wishlist && $request->has('product_id')) {
            $wishlist = ProductWishlist::where('product_id', $request->product_id)
                ->where('user_id', Auth::id())
                ->first();
        }

        if (!$wishlist) {
            return response()->json(['error' => 'Wishlist item not found'], 404);
        }

        $wishlist->delete();

        return response()->json(['message' => 'Product removed from wishlist successfully']);
    }

    // public function destroy(Request $request)
    // {

    //     if (!Auth::check()) {
    //         return response()->json(['error' => 'Please log in to remove from wishlist'], 401);
    //     }

    //     $user = Auth::user();
    //     $product_id = $request->product_id;
    //     ProductWishlist::where('user_id', $user->id)->where('product_id', $product_id)->delete();

    //     return response()->json(['message' => 'Product removed from wishlist successfully']);
    // }

    public function wishlistCount()
    {
        $count = 0;
        if (Auth::check()) {
            $count = ProductWishlist::where('user_id', Auth::id())->count();
        }
        return response()->json(['count' => $count]);
    }



    public function moveToWishlist(Request $request)
    {

        if (!Auth::check()) {
            return response()->json(['error' => 'Please log in to add to wishlist'], 401);
        }

        $user = Auth::user();
        $product_id = $request->product_id;

        $wishlistItem = ProductWishlist::where('user_id', $user->id)
            ->where('product_id', $product_id)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return response()->json(['message' => 'Removed from wishlist', 'status' => 'removed']);
        } else {
            ProductWishlist::create([
                'user_id' => $user->id,
                'product_id' => $product_id,
            ]);
            $cart = session()->get('cart', []);
            if (isset($cart[$product_id])) {
                unset($cart[$product_id]);
                session()->put('cart', $cart);
            }

            return response()->json(['message' => 'Product added to wishlist successfully', 'status' => 'added']);
        }
    }
}
