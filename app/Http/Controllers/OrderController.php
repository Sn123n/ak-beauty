<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\UserAddress;
use App\Models\OrderDetail;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\PlaceOrderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    public function checkPincode(Request $request)
    {
        $pincode = $request->pincode;
        $shippingPrice = DB::table('pincode')->where('pincode', $pincode)->value('price');

        if ($shippingPrice !== null) {
            return response()->json([
                'success' => true,
                'price' => (float) $shippingPrice
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function getShippingCharge(Request $request)
    {
        $pincode = $request->input('pincode');
        $shippingCharge = DB::table('pincode')->where('pincode', $pincode)->value('price') ?? 0;

        return response()->json([
            'shippingCharge' => $shippingCharge
        ]);
    }


    // public function placeOrder(Request $request)
    // {
    //     // dd($request->all());
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'last_name' => 'nullable|string|max:255',
    //         'email' => 'required|email',
    //         'phone' => 'required|string|max:15',
    //         'address' => 'required|string',
    //         'country' => 'required|string',
    //         'state' => 'nullable|string',
    //         'city' => 'nullable|string',
    //         'pincode' => 'nullable|string|max:10',
    //         'payment_method' => 'required|string|in:cod,online',
    //         'orderData' => 'required|json',
    //     ]);

    //     $orderData = json_decode($request->orderData, true);

    //     $user = auth()->user(); // Get logged-in user

    //     if (!$user) {
    //         return response()->json([
    //             'message' => 'Unauthorized access. Please log in to place an order.'
    //         ], 403);
    //     }

    //     $shippingCharge = DB::table('pincode')
    //         ->where('pincode', $validatedData['pincode'])
    //         ->value('price') ?? 0;

    //     $order = new Order();
    //     $order->user_id = auth()->id();
    //     $order->sub_total = $orderData['subtotal'];
    //     $order->shipping_charge = $shippingCharge;
    //     $order->tax = $orderData['tax'];
    //     $order->coupon_code_discount = $orderData['couponDiscount'] ?? 0;
    //     $order->payment_method = $validatedData['payment_method'];
    //     $order->payment_status = 'pending';
    //     $order->status = 'pending';
    //     $order->product_discount = $orderData['discountTotal'] ?? 0;
    //     $order->total_amount = $orderData['totalAmount'];

    //     $order->order_id = 'FS_' . Carbon::now()->year . '_' . mt_rand(100000, 999999);

    //     // dd($order);
    //     $order->save();

    //     foreach ($orderData['cart'] as $item) {
    //         OrderDetail::create([
    //             'order_id' => $order->id,
    //             'product_id' => $item['id'],
    //             'quantity' => $item['qnty'],
    //             'price' => $item['price'],
    //             'subtotal' => $item['price'] * $item['qnty'],
    //             'status' => 'pending',
    //             'first_name' => $validatedData['name'],
    //             'last_name' => $validatedData['last_name'],
    //             'email' => $validatedData['email'],
    //             'phone' => $validatedData['phone'],
    //             'address' => $validatedData['address'],
    //             'country' => $validatedData['country'],
    //             'state' => $validatedData['state'],
    //             'city' => $validatedData['city'],
    //             'pincode' => $validatedData['pincode'],
    //         ]);
    //     }

    //     UserAddress::updateOrCreate(
    //         ['user_id' => auth()->id()],
    //         [
    //             'name' => $validatedData['name'],
    //             'email' => $validatedData['email'],
    //             'address' => $validatedData['address'],
    //             'country' => $validatedData['country'],
    //             'state' => $validatedData['state'],
    //             'city' => $validatedData['city'],
    //             'pincode' => $validatedData['pincode'],
    //         ]
    //     );

    //     session()->forget('cart');
    //     session()->forget('applied_coupon');

    //     Mail::to($user->email)->send(new PlaceOrderMail($order));

    //     return response()->json([
    //         'message' => 'Order placed successfully',
    //         'redirect_url' => route('order_confirm.order', ['orderId' => $order->id])
    //     ]);
    // }



    public function placeOrder(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required|digits:10',
            'address' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'pincode' => 'required|string|max:6',
            'payment_method' => 'required|string|in:cod,online',
            'orderData' => 'required|json',
        ]);

        $orderData = json_decode($request->orderData, true);
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized access. Please log in to place an order.'
            ], 403);
        }

        $shippingCharge = DB::table('pincode')
            ->where('pincode', $validatedData['pincode'])
            ->value('price') ?? 0;

        $coupon = session('applied_coupon', []);

        $order = new Order();
        $order->user_id = auth()->id();
        $order->sub_total = $orderData['subtotal'];
        $order->shipping_charge = $shippingCharge;
        $order->tax = $orderData['tax'];
        $order->coupon_code_discount = $orderData['couponDiscount'] ?? 0;

        $order->coupon_id = $orderData['couponDetails']['id'] ?? null;
        $order->coupon_title = $orderData['couponDetails']['title'] ?? null;
        $order->coupon_start_date = $orderData['couponDetails']['start_date'] ?? null;
        $order->coupon_expiry_date = $orderData['couponDetails']['expiry_date'] ?? null;

        $order->payment_method = $validatedData['payment_method'];
        $order->payment_status = 'pending';
        $order->status = 'pending';
        $productDiscount = $orderData['discountTotal'] ?? 0;
        $couponDiscount = $orderData['couponDiscount'] ?? 0;

        $order->product_discount = $productDiscount;
        $order->coupon_code_discount = $couponDiscount;

        // Save the combined total discount
        $order->total_discount = $productDiscount + $couponDiscount;

        $order->total_amount = $orderData['totalAmount'];
        $order->order_id = 'RS' . mt_rand(100000, 999999);

        // Shipping info
        $order->name = $validatedData['name'];
        $order->last_name = $validatedData['last_name'];
        $order->email = $validatedData['email'];
        $order->phone = $validatedData['phone'];
        $order->address = $validatedData['address'];
        $order->country = $validatedData['country'];
        $order->state = $validatedData['state'];
        $order->city = $validatedData['city'];
        $order->pincode = $validatedData['pincode'];

        $order->save();

        foreach ($orderData['cart'] as $item) {
            // dd($item);
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_title' => $item['title'],
                'quantity' => $item['qnty'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['qnty'],
                'discount_price' => $item['discounted_price'] ?? 0,
                'discount_subtotal' => $item['discounted_price'] * $item['qnty'] ?? 0,
                'status' => 'pending',
            ]);
        }


        UserAddress::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'address' => $validatedData['address'],
                'country' => $validatedData['country'],
                'state' => $validatedData['state'],
                'city' => $validatedData['city'],
                'pincode' => $validatedData['pincode'],
            ]
        );

        $not=  Notification::create([
            'order_id' => $order->id,
            'type' => 'new_booking',
            'status' => 0, 
        ]);
        // dd($not);
        session()->forget('cart');
        session()->forget('applied_coupon');

        $emailContent = View::make('front.emails.place_order', [
            'order' => $order
        ])->render();

        sendRegistrationEmail($user->email, 'Order Confirmation - Your Order #' . $order->order_id, $emailContent);

        return response()->json([
            'message' => 'Order placed successfully',
            'redirect_url' => route('order_confirm.order', ['orderId' => $order->id])
        ]);
    }

    public function order_confirm($orderId)
    {
        $order = Order::findOrFail($orderId);

        $seoData = getSeo('user_order_success');
        $meta_title = $seoData['meta_title'] ?? '';
        $meta_keywords = $seoData['meta_keywords'] ?? '';
        $meta_description = $seoData['meta_description'] ?? '';

        return view('front.product.order_confirm', compact('order', 'meta_title', 'meta_keywords', 'meta_description'));
    }
}
