<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Categories;
use App\Models\ProductWishlist;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\UserAddress;
use App\Models\Location;
use App\Models\ProductReview;
use App\Models\Order;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;


class DashboardController extends Controller
{


    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('user.login');
        }

        $user = Auth::user();

        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)
            ->whereHas('orderDetails', function ($query) {
                $query->where('status', 'pending');
            })
            ->count();

        $wishlistCount = ProductWishlist::where('user_id', $user->id)->count();

        $seoData = getSeo('user_dashboard');
        extract($seoData);

        $userAddresses = UserAddress::where('user_id', $user->id)->get();
        $countries = Location::where('location_type', 0)->where('status', 0)->get();

        return view('front.dashboard.profile', compact(
            'user',
            'totalOrders',
            'pendingOrders',
            'wishlistCount',
            'userAddresses',
            'countries',
            'meta_title',
            'meta_keywords',
            'meta_description'
        ));
    }


    public function orderlist(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('user.login');
        }

        $user = Auth::user();
        $query = Order::where('user_id', $user->id);

        // Check if a status filter is passed
        if ($request->has('status') && $request->status !== '') {
            $query->whereHas('orderDetails', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        // Loop through orders to get order details status for each order
        foreach ($orders as $order) {
            // Assuming the first status of the order details is what you want to display
            $order->order_status = $order->orderDetails->first()->status ?? 'not available';
        }

        $orderbanner = DB::table('banners')->where('name', 'order')->where('status', 1)->first();
        $seoData = getSeo('user_order_history');
        extract($seoData);

        return view('front.dashboard.orders', compact(
            'orders',
            'orderbanner',
            'meta_title',
            'meta_keywords',
            'meta_description'
        ));
    }



    public function orderDetails($id)
    {
        if (!Auth::check()) {
            return redirect()->route('user.login');
        }
        $order = Order::with('orderDetails.product.categories')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        $orderbanner = DB::table('banners')->where('name', 'order')->where('status', 1)->first();
        $seoData = getSeo('user_order_detail');
        extract($seoData);

        return view('front.dashboard.view_order_details', compact(
            'order',
            'meta_title',
            'meta_keywords',
            'meta_description',
            'orderbanner'
        ));
    }



    public function account_detail()
    {
        if (!Auth::check()) {
            return redirect()->route('user.login');
        }
        $user = Auth::user();
        $countries = Location::where('location_type', 0)->where('status', 0)->get();
        $selectedCountry = $user->country;
        $selectedState   = $user->state;
        $selectedCity    = $user->city;
        $accbanner = DB::table('banners')->where('name', 'acoountdetail')->where('status', 1)->first();
        $seoData = getSeo('user_edit_profile');
        extract($seoData);

        return view('front.dashboard.account_detail', compact(
            'user',
            'countries',
            'selectedCountry',
            'selectedState',
            'selectedCity',
            'accbanner',
            'meta_title',
            'meta_keywords',
            'meta_description'
        ));
    }

    public function updateaccount(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'phone' => 'required|string|max:10|min:10',
            'gender' => 'required|in:0,1',
            'dob' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'address' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'pincode' => 'required|string|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = User::findOrFail($id);

        try {
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->address = $request->address;
            $user->country = $request->country;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->pincode = $request->pincode;

            // Image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($user->image && file_exists(public_path('user/' . $user->image))) {
                    unlink(public_path('user/' . $user->image));
                }

                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('user'), $imageName);
                $user->image = $imageName;
            }

            $user->save();

            return response()->json(['status' => 'success', 'message' => 'Account details updated.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function address()
    {
        if (!Auth::check()) {
            return redirect()->route('user.login');
        }
        $user = Auth::user();
        $userAddress = UserAddress::where('user_id', $user->id)->first();
        $countries = Location::where('location_type', 0)->where('status', 0)->get();
        $selectedBillingCountry = $user->country;
        $selectedBillingState   = $user->state;
        $selectedBillingCity    = $user->city;

        $selectedShippingCountry = $userAddress->country ?? '';
        $fetchShippingStates     = $userAddress->state ?? '';
        $fetchShippingCities     = $userAddress->city ?? '';
        $addressbanner = DB::table('banners')->where('name', 'address')->where('status', 1)->first();
        $seoData = getSeo('user_address');
        extract($seoData);

        return view('front.dashboard.address', compact(
            'userAddress',
            'countries',
            'selectedShippingCountry',
            'fetchShippingStates',
            'fetchShippingCities',
            'user',
            'selectedBillingCity',
            'selectedBillingState',
            'selectedBillingCountry',
            'addressbanner',
            'meta_title',
            'meta_keywords',
            'meta_description'
        ));
    }


    public function updateaddress(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns',
            'address' => 'required|string',
            'country' => 'required|integer',
            'state' => 'required|integer',
            'city' => 'required|integer',
            'pincode' => 'required|string|max:6',
        ]);

        $user = Auth::user();
        $userAddress = UserAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'pincode' => $request->pincode,
            ]
        );

        return response()->json(['status' => 'success', 'message' => 'shipping Address updated successfully!']);
    }

    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'address' => 'nullable|string',
            'country' => 'nullable|integer',
            'state' => 'nullable|integer',
            'city' => 'nullable|integer',
            'pincode' => 'nullable|string|max:10',
        ]);

        try {
            $user = Auth::user();
            
            // Update name and email
            $user->name = $request->first_name . ($request->last_name ? ' ' . $request->last_name : '');
            $user->lastname = $request->last_name ?? '';
            $user->email = $request->email;
            
            // Update address fields (stored in users table - billing address)
            $user->address = $request->address ?? null;
            $user->country = $request->country ?? null;
            $user->state = $request->state ?? null;
            $user->city = $request->city ?? null;
            $user->pincode = $request->pincode ?? null;
            
            $user->save();

            return response()->json(['status' => 'success', 'message' => 'Profile updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function storeAddress(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'apartment' => 'nullable|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'nullable|string|max:10',
        ]);

        $user = Auth::user();

        $address = UserAddress::create([
            'user_id' => $user->id,
            'name' => $request->first_name,
            'email' => $request->email ?? $user->email,
            'address' => $request->address,
            'apartment' => $request->apartment ?? '',
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'pincode' => $request->pincode ?? '',
        ]);

        // Get location names for response
        $countryName = $address->country;
        $stateName = $address->state;
        $cityName = $address->city;

        return response()->json([
            'status' => 'success', 
            'message' => 'Address added successfully!', 
            'address' => [
                'id' => $address->id,
                'name' => $address->name,
                'email' => $address->email,
                'address' => $address->address,
                'apartment' => $address->apartment ?? '',
                'country' => $address->country,
                'state' => $address->state,
                'city' => $address->city,
                'pincode' => $address->pincode,
                'country_name' => $countryName,
                'state_name' => $stateName,
                'city_name' => $cityName,
            ]
        ]);
    }

    public function updateUserAddress(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'address' => 'required|string',
            'apartment' => 'nullable|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'nullable|string|max:10',
        ]);

        $user = Auth::user();
        $address = UserAddress::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        // If this is set as default, remove default from other addresses
        if ($request->is_default) {
            UserAddress::where('user_id', $user->id)->where('id', '!=', $id)->update(['is_default' => 0]);
        }

        $address->update([
            'name' => $request->first_name . ($request->last_name ? ' ' . $request->last_name : ''),
            'address' => $request->address,
            'apartment' => $request->apartment ?? '',
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'pincode' => $request->pincode ?? '',
        ]);

        // Get location names for response
        $countryName = $address->country;
        $stateName = $address->state;
        $cityName = $address->city;

        return response()->json([
            'status' => 'success', 
            'message' => 'Address updated successfully!', 
            'address' => [
                'id' => $address->id,
                'name' => $address->name,
                'email' => $address->email ?? '',
                'address' => $address->address,
                'apartment' => $address->apartment ?? '',
                'country' => $address->country,
                'state' => $address->state,
                'city' => $address->city,
                'pincode' => $address->pincode,
                'country_name' => $countryName,
                'state_name' => $stateName,
                'city_name' => $cityName,
            ]
        ]);
    }

    public function getAddress($id)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $address = UserAddress::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        // Since state, city, and country are now text fields, use them directly
        $countryName = $address->country ?? '';
        $stateName = $address->state ?? '';
        $cityName = $address->city ?? '';

        // Split name into first and last
        $nameParts = explode(' ', $address->name ?? '', 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        // Get address and apartment separately
        $addressText = $address->address ?? '';
        $apartment = $address->apartment ?? '';

        return response()->json([
            'status' => 'success',
            'address' => [
                'id' => $address->id,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $address->email ?? '',
                'address' => $addressText,
                'apartment' => $apartment,
                'country' => $address->country ?? '',
                'state' => $address->state ?? '',
                'city' => $address->city ?? '',
                'pincode' => $address->pincode ?? '',
                'country_name' => $countryName,
                'state_name' => $stateName,
                'city_name' => $cityName,
            ]
        ]);
    }

    public function deleteAddress($id)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $address = UserAddress::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $address->delete();

        return response()->json(['status' => 'success', 'message' => 'Address deleted successfully!']);
    }

    public function updatebillingaddress(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'country' => 'required|integer',
            'state' => 'required|integer',
            'city' => 'required|integer',
            'address' => 'required|string',
            'pincode' => 'required|string|max:6',
        ]);

        Auth::user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'address' => $request->address,
            'pincode' => $request->pincode,
        ]);

        // Step 3: Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Billing Address updated successfully!',
        ]);
    }


    public function change_password()
    {
        if (!Auth::check()) {
            return redirect()->route('user.login');
        }
        $user = User::find(auth()->id());
        $passbanner = DB::table('banners')->where('name', 'changepass')->where('status', 1)->first();
        $seoData = getSeo('user_reset_password');
        extract($seoData);
        return view('front.dashboard.change_password', compact('user', 'passbanner', 'meta_title', 'meta_keywords', 'meta_description'));
    }

    public function update_password(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6|different:old_password',
            'confirm_password' => 'required|same:new_password',
        ]);

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return response()->json([
                'status' => 'error',
                'errors' => ['old_password' => ['The provided old password is incorrect.']]
            ], 422);
        }


        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully!',
            'redirect' => route('user.login')
        ]);
    }
    public function productlist(Request $request)
    {
        $category_id = $request->category_id;
        $category = null;
        $categories = Categories::where('status', 1)->get();

        if ($category_id) {
            $category = Categories::where('id', $category_id)->where('status', 1)->first();
            $products = Product::where('category_id', $category_id)->where('status', 1)->paginate(12);
        } else {
            $products = Product::where('status', 1)->paginate(12);
        }

        return view('front.product.product', compact('category_id', 'category', 'products', 'categories'));
    }




    public function productdetail($id)
    {
        $product = Product::where('id', $id)->where('status', 1)->first();

        if (!$product) {
            abort(404, 'Product not found');
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->where('status', 1)
            ->limit(8)
            ->get();

        $wishlist = Auth::check()
            ? ProductWishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        $reviews = ProductReview::where('product_id', $id)->with(['user'])->latest()->get();
        $seoData = getSeo('user_product_detail');
        extract($seoData);

        return view('front.product.product-details', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'wishlist' => $wishlist,
            'reviews' => $reviews,
            'meta_title' => $meta_title,
            'meta_keywords' => $meta_keywords,
            'meta_description' => $meta_description
        ]);
    }



    public function getProductsByCategory(Request $request)
    {
        // If it's not an AJAX request, redirect to product list page with category filter
        if (!$request->ajax() && !$request->wantsJson() && $request->has('category_id')) {
            return redirect()->route('product.list', ['category_id' => $request->category_id]);
        }

        $category_id = $request->category_id;
        $sort_by = $request->sort_by;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $final_price_sql = "
            ROUND(
                CASE
                    WHEN discount IS NULL THEN price
                    WHEN discount_type = 'percent' THEN price - (price * discount / 100)
                    WHEN discount_type = 'rs' THEN price - discount
                    ELSE price
                END, 2
            )
        ";
        $query = Product::select('*', DB::raw("$final_price_sql as final_price"))
            ->where('status', 1);

        if ($category_id) {
            $query->where('category_id', $category_id);
        }
        $maxPrice = (clone $query)->max(DB::raw($final_price_sql)) ?? 0;

        // Price filter - handle min only, max only, or both
        if (!empty($min_price) || !empty($max_price)) {
            $min_price = !empty($min_price) ? (float)$min_price : 0;
            $max_price = !empty($max_price) ? (float)$max_price : PHP_INT_MAX;

            if ($min_price >= 0 && $max_price > 0 && $max_price >= $min_price) {
                $query->whereRaw("ROUND($final_price_sql, 2) >= ? AND ROUND($final_price_sql, 2) <= ?", [$min_price, $max_price]);
            }
        }

        switch (strtolower($sort_by ?? '')) {
            case "price: low to high":
            case "price-low-high":
                $query->orderBy('final_price', 'asc');
                break;
            case "price: high to low":
            case "price-high-low":
                $query->orderBy('final_price', 'desc');
                break;
            case "what's new":
            case "whats-new":
                $query->orderBy('created_at', 'desc');
                break;
            case "better discount":
            case "better-discount":
                $query->orderByRaw('COALESCE(discount, 0) DESC');
                break;
            default:
                $query->orderBy('id', 'desc');
        }

        $products = $query->paginate(12);
        $wishlist = Auth::check()
            ? ProductWishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        try {
            $productsHtml = view('front.product.filtered_product', compact('products', 'wishlist'))->render();

            return response()->json([
                'products' => $productsHtml,
                'maxPrice' => ceil($maxPrice),
                'pageination' => $products->total() > 12 ? (string)$products->links() : '',
                'debug_total' => $products->total(),
                'count' => $products->count()
            ]);
        } catch (\Exception $e) {
            \Log::error('Filter error: ' . $e->getMessage());
            return response()->json([
                'products' => '<div class="col-12 text-center py-5"><p class="text-danger">Error loading products.</p></div>',
                'maxPrice' => 0,
                'pageination' => '',
                'debug_total' => 0,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePrices(Request $request)
    {
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // Fetch products within the given price range
        $products = Product::whereBetween('price', [$minPrice, $maxPrice])->get();

        // Return updated product prices
        return response()->json([
            'updatedPrices' => $products->pluck('price')
        ]);
    }

    public function getMinPrice(Request $request)
    {
        $category_id = $request->category_id;

        $query = Product::select(DB::raw("
        MIN(
            CASE
                WHEN discount IS NULL THEN price
                WHEN discount_type = 'percent' THEN price - (price * discount / 100)
                WHEN discount_type = 'rs' THEN price - discount
                ELSE price
            END
        ) as min_discounted_price
     "))
            ->where('status', 1);
        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        $minPrice = $query->value('min_discounted_price') ?? 0;

        return response()->json(['minPrice' => floor($minPrice)]);
    }

    public function getMaxPrice(Request $request)
    {
        $category_id = $request->category_id;

        // Assuming that category_id is being passed correctly
        $query = Product::select(DB::raw("
        MAX(
            CASE
                WHEN discount IS NULL THEN price
                WHEN discount_type = 'percent' THEN price - (price * discount / 100)
                WHEN discount_type = 'rs' THEN price - discount
                ELSE price
            END
        ) as max_discounted_price
    "))
            ->where('status', 1);

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        $maxPrice = $query->value('max_discounted_price') ?? 0;
        return response()->json(['maxPrice' => $maxPrice]);
    }


    public function category()
    {
        $data['categories'] = Categories::where('status', 1)->get();
        $seoData = getSeo('user_category');
        $data['meta_title'] = $seoData['meta_title'] ?? '';
        $data['meta_keywords'] = $seoData['meta_keywords'] ?? '';
        $data['meta_description'] = $seoData['meta_description'] ?? '';

        return view('front.category.index', $data);
    }



    public function addToCart(Request $request)
    {
        $cart = Session::get('cart', []);

        if (!empty($request->discount_type) && !empty($request->discount)) {
            if ($request->discount_type == 'percent') {
                $discountedPrice = $request->price - ($request->price * $request->discount) / 100;
            } elseif ($request->discount_type == 'rs') {
                $discountedPrice = $request->price - $request->discount;
            } else {
                $discountedPrice = $request->price;
            }
        } else {
            $discountedPrice = $request->price;
        }

        $discountedPrice = max($discountedPrice, 0);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['qnty'] += 1;
        } else {
            $cart[$request->id] = [
                "id" => $request->id,
                "title" => $request->title,
                "price" => $request->price,
                "discount" => $request->discount,
                "discount_type" => $request->discount_type,
                "discounted_price" => $discountedPrice,
                "image" => $request->image,
                "qnty" => $request->qnty,
                "category_id" => $request->category_id,
            ];
        }

        Session::put('cart', $cart);

        if (Auth::check()) {
            ProductWishlist::where('user_id', Auth::id())
                ->where('product_id', $request->id)
                ->delete();
        }


        return response()->json([
            'message' => 'Product added to cart successfully!',
            'cart' => $cart
        ]);
    }


    public function addToCartDetailpage(Request $request)
    {
        $cart = Session::get('cart', []);

        if (!empty($request->discount_type) && !empty($request->discount)) {
            if ($request->discount_type == 'percent') {
                $discountedPrice = $request->price - ($request->price * $request->discount) / 100;
            } elseif ($request->discount_type == 'rs') {
                $discountedPrice = $request->price - $request->discount;
            } else {
                $discountedPrice = $request->price;
            }
        } else {
            $discountedPrice = $request->price;
        }
        $discountedPrice = max($discountedPrice, 0);

        if (isset($cart[$request->id])) {
            // Update the quantity of an existing item
            $cart[$request->id]['qnty'] += $request->qnty;
        } else {
            // Add a new item to the cart
            $cart[$request->id] = [
                "id" => $request->id,
                "title" => $request->title,
                "price" => $request->price,
                "discount" => $request->discount,
                "discount_type" => $request->discount_type,
                "discounted_price" => $discountedPrice,
                "image" => $request->image,
                "qnty" => $request->qnty,
                "category_id" => $request->category_id,

            ];
        }

        Session::put('cart', $cart);

        return response()->json(['message' => 'Product added to cart successfully!', 'cart' => $cart]);
    }

    public function updateToCart(Request $request)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['qnty'] = $request->qnty;
        } else {
            $cart[$request->id] = [
                "id" => $request->id,
                "title" => $request->title,
                "price" => $request->price,
                "image" => $request->image,
                "qnty" => $request->qnty
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'status' => true,
            'message' => 'Cart updated successfully!',
            'cart' => $cart
        ]);
    }


    public function removeFromCart(Request $request)
    {
        $cart = Session::get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }

        if (empty($cart)) {
            Session::forget('applied_coupon');
        }

        return response()->json([
            'status' => true,
            'message' => 'Product removed from cart',
            'cart' => $cart
        ]);
    }



    public function cart()
    {
        $cart = Session::get('cart', []);
        $subtotal = 0;
        $mrpTotal = 0;
        $totalDiscount = 0;

        foreach ($cart as &$product) {
            if (isset($product['category_id'])) {
                $category = DB::table('categories')->where('id', $product['category_id'])->first();
                $product['category_name'] = $category ? $category->name : 'No Category';
            } else {
                $product['category_name'] = 'No Category';
            }

            // Calculate totals
            $qty = $product['qnty'] ?? 1;
            $price = $product['price'] ?? 0;
            $discountedPrice = $product['discounted_price'] ?? $price;

            $mrpTotal += $price * $qty;
            $subtotal += $discountedPrice * $qty;
            $totalDiscount += ($price - $discountedPrice) * $qty;
        }

        Session::put('cart', $cart);
        $seoData = getSeo('user_cart');
        extract($seoData);

        // Get user address if logged in
        $userAddress = null;
        $userAddresses = [];
        $countries = [];
        $deliveryCharge = 100; // Default delivery charge
        
        if (Auth::check()) {
            $userAddress = UserAddress::where('user_id', Auth::id())->first();
            $userAddresses = UserAddress::where('user_id', Auth::id())->get();
            $countries = Location::where('location_type', 0)->where('status', 0)->get();
            
            // Calculate delivery charge based on user address pincode
            if ($userAddress && $userAddress->pincode) {
                $pincodeData = DB::table('pincode')
                    ->where('pincode', $userAddress->pincode)
                    ->first();
                if ($pincodeData && $pincodeData->price) {
                    $deliveryCharge = $pincodeData->price;
                }
            }
        }

        return view('front.product.cart', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'mrpTotal' => $mrpTotal,
            'totalDiscount' => $totalDiscount,
            'deliveryCharge' => $deliveryCharge,
            'meta_title' => $meta_title ?? '',
            'meta_keywords' => $meta_keywords ?? '',
            'meta_description' => $meta_description ?? '',
            'user' => Auth::user(),
            'userAddress' => $userAddress,
            'userAddresses' => $userAddresses,
            'countries' => $countries,
        ]);
    }



    public function getcoupon()
    {

        $today = Carbon::today();
        $coupons = Coupon::whereDate('expiry_date', '>=', $today)->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($coupon) {
                $discount = ($coupon->discount_type == 'percentage')
                    ? $coupon->discount_percentage . '%'
                    : 'Rs. ' . $coupon->discount_rupees;

                return [
                    'id' => $coupon->id,
                    'title' => $coupon->title,
                    'coupon_code' => $coupon->coupon_code,
                    'description' => $coupon->description,
                    'expiry_date' => $coupon->expiry_date,
                    'discount_type' => $coupon->discount_type,
                    'discount' => $discount,
                    'discount_value' => ($coupon->discount_type == 'percentage') ? $coupon->discount_percentage : $coupon->discount_rupees,
                    'discount_type' => $coupon->discount_type
                ];
            });
        // dd($coupons);
        return response()->json([
            'status' => true,
            'message' => 'Coupons retrieved successfully',
            'coupons' => $coupons
        ]);
    }

    public function validateCoupon(Request $request)
    {
        $today = Carbon::today();
        $coupon = Coupon::where('coupon_code', $request->coupon_code)
            ->whereDate('expiry_date', '>=', $today)
            ->first();

        if ($coupon) {
            return response()->json([
                'valid' => true,
                'message' => 'Coupon applied successfully!',
                'discount' => ($coupon->discount_type == 'percentage') ? $coupon->discount_percentage . '%' : 'Rs. ' . $coupon->discount_rupees
            ]);
        } else {
            return response()->json([
                'valid' => false,
                'message' => 'Coupon is expired.'
            ]);
        }
    }


    public function applyCoupon(Request $request)
    {
        $couponCode = $request->coupon_code;
        $coupon = Coupon::where('coupon_code', $couponCode)->first();
        // dd($coupon);
        if (!$coupon) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid coupon code.',
            ]);
        }

        if (Carbon::parse($coupon->expiry_date)->endOfDay() < now()) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon has expired.',
            ]);
        }

        $discountValue = ($coupon->discount_type === 'percentage') ? $coupon->discount_percentage : $coupon->discount_rupees;

        session(['applied_coupon' => [
            'id' => $coupon->id,
            'code' => $coupon->coupon_code,
            'title' => $coupon->title,
            'start_date' => $coupon->start_date,
            'expiry_date' => $coupon->expiry_date,
            'type' => $coupon->discount_type,
            'discount' => $discountValue
        ]]);

        return response()->json([
            'status' => true,
            'message' => 'Coupon applied successfully.',
            'discount' => $discountValue,
            'type' => $coupon->discount_type
        ]);
    }


    public function clearCart()
    {
        session()->forget('cart');
        session()->forget('applied_coupon');
        return redirect()->back()->with('success', 'Cart cleared successfully.');
    }

    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $totalCount = 0;
        
        foreach ($cart as $item) {
            $totalCount += $item['qnty'] ?? 1;
        }

        return response()->json(['count' => $totalCount]);
    }

    public function getcart()
    {
        $cart = session()->get('cart', []);
        // dd($cart);
        return response()->json([
            'cart' => $cart
        ]);
    }

    public function remove(Request $request)
    {
        $cart = Session::get('cart', []);
        $cart = array_filter($cart, function ($item) use ($request) {
            return $item['id'] != $request->product_id;
        });

        Session::put('cart', array_values($cart));

        return response()->json(['message' => 'Product removed from cart']);
    }

    public function update(Request $request)
    {
        $cart = Session::get('cart', []);
        foreach ($cart as &$item) {
            if ($item['id'] == $request->product_id) {
                $item['qnty'] = max(1, $item['qnty'] + $request->change);
            }
        }

        Session::put('cart', $cart);

        return response()->json(['message' => 'Cart updated']);
    }




    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('user.login')->with('error', 'Please login to proceed to checkout.');
        }

        $cart = Session::get('cart', []);
        $coupon = Session::get('applied_coupon');
        // dd(Session::all());
        $user = Auth::user();
        $userAddress = UserAddress::where('user_id', $user->id)->first();
        $countries = Location::where('location_type', 0)->where('status', 0)->get();

        $selectedCountry = $userAddress->country ?? null;
        $selectedState   = $userAddress->state ?? null;
        $selectedCity    = $userAddress->city ?? null;

        $checkoutbanner = DB::table('banners')->where('name', 'checkout')->where('status', 1)->first();

        $seoData = getSeo('user_checkout');
        extract($seoData);

        return view('front.product.checkout', compact(
            'cart',
            'coupon',
            'user',
            'selectedCountry',
            'selectedState',
            'selectedCity',
            'countries',
            'userAddress',
            'checkoutbanner',
            'meta_title',
            'meta_keywords',
            'meta_description'
        ));
    }




    public function storereview(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => false, 'message' => 'You need to be logged in to submit a review.'], 401);
        }


        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns',
            'review' => 'required|string|max:1000',
        ]);

        try {
            $review = ProductReview::create([
                'product_id' => $request->product_id,
                'user_id' => auth()->id(),
                'name' => $request->name,
                'email' => $request->email,
                'review' => $request->review,
            ]);
            $not = Notification::create([
                'review_id' => $review->id,
                'type' => 'product_review',
                'status' => 0,
            ]);

            return response()->json(['success' => true, 'message' => 'Review submitted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong!'], 500);
        }
    }



    public function search(Request $request)
    {
        $query = $request->query('query');

        // Category search with status = 1
        $categories = Categories::where('status', 1)
            ->where('name', 'like', '%' . $query . '%')
            ->limit(5)
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'image' => asset('categories/' . $category->image),
                    'link' => route('products.filter', ['id' => $category->id])
                ];
            });

        // Product search with status = 1
        $products = Product::where('status', 1)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%');
                //   ->orWhereHas('categories', function ($q2) use ($query) {
                //       $q2->where('name', 'like', '%' . $query . '%');
                //   });
            })
            ->limit(10)
            ->get()
            ->map(function ($product) {
                if ($product->discount_type === 'percent') {
                    $discountedPrice = $product->price - ($product->price * $product->discount / 100);
                } elseif ($product->discount_type === 'rs') {
                    $discountedPrice = $product->price - $product->discount;
                } else {
                    $discountedPrice = $product->price;
                }

                $priceHtml = $product->discount > 0
                    ? '<del>₹' . number_format($product->price, 2) . '</del> <ins>₹' . number_format(max($discountedPrice, 0), 2) . '</ins>'
                    : '<ins>₹' . number_format($product->price, 2) . '</ins>';

                return [
                    'name' => $product->title,
                    'image' => asset('product/' . $product->image),
                    'link' => route('product.detail', $product->id),
                    'price_html' => $priceHtml
                ];
            });

        return response()->json([
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public function fetchStatesByCountry(Request $request)
    {
        $countryId = $request->input('country_id');
        if (!$countryId) {
            return response()->json(['states' => []]);
        }
        
        // Convert to integer for proper comparison
        $countryId = (int)$countryId;
        
        $states = Location::where('location_type', 1)
            ->where('parent_id', $countryId)
            ->where('status', 0)
            ->orderBy('name', 'asc')
            ->get();
        
        // Format response properly
        $formattedStates = $states->map(function($state) {
            return [
                'location_id' => (int)$state->location_id,
                'name' => $state->name
            ];
        });
        
        return response()->json(['states' => $formattedStates]);
    }

    public function fetchCitiesByState(Request $request)
    {
        $stateId = $request->input('state_id');
        if (!$stateId) {
            return response()->json(['cities' => []]);
        }
        
        // Convert to integer for proper comparison
        $stateId = (int)$stateId;
        
        $cities = Location::where('location_type', 2)
            ->where('parent_id', $stateId)
            ->where('status', 0)
            ->orderBy('name', 'asc')
            ->get();
        
        // Format response properly
        $formattedCities = $cities->map(function($city) {
            return [
                'location_id' => (int)$city->location_id,
                'name' => $city->name
            ];
        });
        
        return response()->json(['cities' => $formattedCities]);
    }
}
