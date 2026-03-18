<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Categories;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use App\Mail\ShippedMail;
use App\Mail\FailMail;
use App\Mail\DeliveredMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use App\Models\ProductWishlist;
use App\Models\Notification;

class AdminController extends Controller
{

    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');
        }
        return view('admin.auth.login');
    }



    public function login_check(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email is required.',
            'password.required' => 'Password is required.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();

            return redirect()->route('dashboard');

            Auth::guard('admin')->logout();
            return back()->withErrors(['invalid' => 'Access denied. Only admins can log in.']);
        }

        return back()->withErrors(['invalid' => 'Invalid credentials']);
    }


    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $request->session()->regenerate();
            Auth::logout();
        }
        return redirect()->route('login');
    }


    public function index()
    {

        $totalProducts = Product::count();
        $category = Categories::count();
        $totalUsersThisMonth = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        if (auth()->check()) {
            return view('admin.dashboard', compact('totalUsersThisMonth', 'totalProducts', 'category'));
        } else {
            return redirect()->route('login');
        }
    }


    public function editprofile()
    {
        $user = User::first();
        return view('admin.auth.edit_profile', compact('user'));
    }

    public function updateprofile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                'max:10'
            ],
            'address' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'email' => 'required|email|unique:users,email,' . $user->id
        ], [
            'phone.regex' => 'Please enter a valid 10-digit mobile number.',
            'phone.max' => 'Phone number must be exactly 10 digits.',
        ]);

        if ($request->hasFile('image')) {
            if ($user && $user->image && file_exists(public_path('profile/' . $user->image))) {
                unlink(public_path('profile/' . $user->image));
            }

            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('profile'), $imageName);

            $user->image = $imageName;
        }

        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }



    public function OrderListing()
    {
        $data['order_history'] = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.order.index')->with($data);
    }



    public function deleteorder(Order $order)
    {
        if ($order) {
            $order->orderDetails()->delete();
            $order->delete();

            return redirect()->route('order_list')->with('success', 'Order and its details deleted successfully.');
        }
        return redirect()->route('order_list')->with('error', 'Order not found.');
    }


    public function deleteorderdetail($id)
    {
        $orderDetail = OrderDetail::find($id);

        if ($orderDetail) {
            $orderDetail->delete();
            return redirect()->back()->with('success', 'Order detail deleted successfully.');
        }

        return redirect()->back()->with('error', 'Order detail not found.');
    }



    public function orderdetail($orderId)
    {
        $order = Order::with('orderDetails.product', 'userAddress')->findOrFail($orderId);
        $data['order_details'] = OrderDetail::with(['order', 'product'])->where('order_id', $orderId)->orderBy('id', 'desc')->get();
        return view('admin.order.view_order', compact('order'))->with($data);
    }

    // public function updateStatus(Request $request)
    // {
    //     try {
    //         $orderDetail = OrderDetail::find($request->order_detail_id);
    //         if ($orderDetail) {
    //             $orderDetail->status = $request->status;
    //             $orderDetail->save();
    //         }

    //         $order = Order::find($request->order_id);
    //         if ($order) {
    //             $order->status = $request->status;
    //             $order->save();

    //             // Send email based on status
    //             if ($order->user) {
    //                 if ($request->status === 'shipped') {
    //                     Mail::to($order->user->email)->send(new ShippedMail($order));
    //                 } elseif ($request->status === 'cancelled') {
    //                     Mail::to($order->user->email)->send(new FailMail($order));
    //                 } elseif ($request->status === 'delivered') {
    //                     Mail::to($order->user->email)->send(new DeliveredMail($order));
    //                 }
    //             }
    //         }

    //         return response()->json(['message' => 'Order status updated successfully!']);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    //     }
    // }

    // public function updateStatus(Request $request)
    // {
    //     try {
    //         $orderDetail = OrderDetail::find($request->order_detail_id);
    //         if ($orderDetail) {
    //             $orderDetail->status = $request->status;
    //             $orderDetail->save();
    //         }

    //         $order = OrderDetail::find($request->order_detail_id);
    //         if ($order) {
    //             $order->status = $request->status;

    //             if ($request->status === 'shipped') {
    //                 $order->shipped_date = now();
    //             }
    //             if ($request->status === 'delivered') {
    //                 $order->delivered_date = now();
    //             }
    //             if ($request->status === 'processing') {
    //                 $order->processing_date = now();
    //             }

    //             $order->save();
    //             // dd($order->user);
    //             if ($order->user) {
    //                 dd(111);
    //                 if ($request->status === 'shipped') {
    //                     Mail::to($order->user->email)->send(new ShippedMail($order));
    //                 } elseif ($request->status === 'cancelled') {
    //                     Mail::to($order->user->email)->send(new FailMail($order));
    //                 } elseif ($request->status === 'delivered') {
    //                     Mail::to($order->user->email)->send(new DeliveredMail($order));
    //                 }
    //             }
    //         }

    //         return response()->json(['message' => 'Order status updated successfully!']);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    //     }
    // }


    // public function updateStatus(Request $request)
    // {
    //     try {
    //         $orderDetail = OrderDetail::find($request->order_detail_id);
    //         if ($orderDetail) {
    //             $orderDetail->status = $request->status;
    //             $orderDetail->save();
    //         }

    //         $order = OrderDetail::find($request->order_detail_id);
    //         if ($order) {
    //             $order->status = $request->status;

    //             if ($request->status === 'shipped') {
    //                 $order->shipped_date = now();
    //             }
    //             if ($request->status === 'delivered') {
    //                 $order->delivered_date = now();
    //             }
    //             if ($request->status === 'processing') {
    //                 $order->processing_date = now();
    //             }

    //             $order->save();
    //             dd($order->user);
    //             if ($order->user) {
    //                 dd(111);
    //                 $email = $order->user->email;
    //                 $viewData = ['order' => $order];

    //                 if ($request->status === 'shipped') {
    //                     $html = View::make('front.emails.shipped', $viewData)->render();
    //                     dd($html);
    //                     sendRegistrationEmail($email, 'Your Order Has Been Shipped!', $html);
    //                 } elseif ($request->status === 'cancelled') {
    //                     $html = View::make('front.emails.fail', $viewData)->render();
    //                     sendRegistrationEmail($email, 'Your Order Has Been Cancelled', $html);
    //                 } elseif ($request->status === 'delivered') {
    //                     $html = View::make('front.emails.delivered', $viewData)->render();
    //                     sendRegistrationEmail($email, 'Your Order Has Been Delivered', $html);
    //                 }
    //             }
    //         }

    //         return response()->json(['message' => 'Order status updated successfully!']);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    //     }
    // }


    // public function updateStatus(Request $request)
    // {
    //     try {
    //         $orderDetail = OrderDetail::with('order.user')->find($request->order_detail_id);
    //         if (!$orderDetail) {
    //             return response()->json(['message' => 'Order detail not found.'], 404);
    //         }

    //         // Update status only in order_detail
    //         $orderDetail->status = $request->status;

    //         // Update relevant date fields based on status
    //         if ($request->status === 'shipped') {
    //             $orderDetail->shipped_date = now();
    //         } elseif ($request->status === 'delivered') {
    //             $orderDetail->delivered_date = now();
    //         } elseif ($request->status === 'processing') {
    //             $orderDetail->processing_date = now();
    //         } elseif ($request->status === 'cancelled') {
    //             $orderDetail->cancelled_date = now();
    //         }

    //         $orderDetail->save();

    //         // Send email to user if order is linked and user exists
    //         if ($orderDetail->order && $orderDetail->order->user) {
    //             $email = $orderDetail->order->user->email;
    //             $viewData = ['order' => $orderDetail];

    //             if ($request->status === 'shipped') {
    //                 // dd(!111);
    //                 $html = View::make('front.emails.shipped', $viewData)->render();
    //                 sendRegistrationEmail($email, 'Your Order Has Been Shipped!', $html);
    //             } elseif ($request->status === 'cancelled') {
    //                 $html = View::make('front.emails.fail', $viewData)->render();
    //                 sendRegistrationEmail($email, 'Your Order Has Been Cancelled', $html);
    //             } elseif ($request->status === 'delivered') {
    //                 $html = View::make('front.emails.delivered', $viewData)->render();
    //                 sendRegistrationEmail($email, 'Your Order Has Been Delivered', $html);
    //             }
    //         } else {
    //             \Log::info('Order or user not found for sending email.', [
    //                 'order_detail_id' => $orderDetail->id,
    //                 'order_id' => $orderDetail->order->id ?? null
    //             ]);
    //         }

    //         return response()->json(['message' => 'Order detail status updated successfully!']);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    //     }
    // }

    public function updateStatus(Request $request)
    {
        try {
            $orderDetail = OrderDetail::with('order.user')->find($request->order_detail_id);

            if (!$orderDetail) {
                return response()->json(['error' => 'Order detail not found.'], 404);
            }

            $currentStatus = $orderDetail->status;
            $newStatus = $request->status;
            if ($currentStatus === 'pending' && $newStatus === 'processing') {
                return response()->json(['error' => 'Cannot change to processing before accept.'], 422);
            } elseif ($currentStatus !== 'accept' && $newStatus === 'shipped') {
                return response()->json(['error' => 'Order must be accept before shipped'], 422);
            } elseif ($currentStatus !== 'shipped' && $newStatus === 'delivered') {
                return response()->json(['error' => 'Order must be shipped before delivery.'], 422);
            }
            $orderDetail->status = $newStatus;
            if ($newStatus === 'accept') {
                $orderDetail->processing_date = now();
            }
            if ($newStatus === 'shipped') {
                $orderDetail->shipped_date = now();
                $orderDetail->delivered_date = null;
            } elseif ($newStatus === 'delivered') {
                $orderDetail->delivered_date = now();
                $orderDetail->cancelled_date = null;
            } elseif ($newStatus === 'cancelled') {
                $orderDetail->cancelled_date = now();
                $orderDetail->processing_date = null;
                $orderDetail->shipped_date = null;
                $orderDetail->delivered_date = null;
                $orderDetail->estimated_delivery_date = null;
            } elseif ($newStatus === 'pending') {
                $orderDetail->cancelled_date = null;
                $orderDetail->processing_date = null;
                $orderDetail->shipped_date = null;
                $orderDetail->delivered_date = null;
                $orderDetail->estimated_delivery_date = null;
            }

            $orderDetail->save();
            if ($orderDetail->order && $orderDetail->order->user) {
                $email = $orderDetail->order->user->email;
                $viewData = ['order' => $orderDetail];

                if ($newStatus === 'shipped') {
                    $html = View::make('front.emails.shipped', $viewData)->render();
                    sendRegistrationEmail($email, 'Your Order Has Been Shipped!', $html);
                } elseif ($newStatus === 'cancelled') {
                    $html = View::make('front.emails.fail', $viewData)->render();
                    sendRegistrationEmail($email, 'Your Order Has Been Cancelled', $html);
                } elseif ($newStatus === 'delivered') {
                    $html = View::make('front.emails.delivered', $viewData)->render();
                    sendRegistrationEmail($email, 'Your Order Has Been Delivered', $html);
                }
            } else {
                \Log::info('Order or user not found for sending email.', [
                    'order_detail_id' => $orderDetail->id,
                    'order_id' => $orderDetail->order->id ?? null
                ]);
            }

            return response()->json(['message' => 'Order detail status updated successfully!', 'status' => $newStatus]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }



    public function setEstimatedDate(Request $request)
    {

        $request->validate([
            'estimated_delivery_date' => 'required|date',
        ]);

        $detail = OrderDetail::find($request->order_detail_id);
        $detail->estimated_delivery_date = $request->estimated_delivery_date;
        $detail->save();

        return response()->json(['success' => true]);
    }

    public function savereason(Request $request)
    {
        $request->validate([
            'reason' => 'required|string',
        ]);

        $detail = OrderDetail::find($request->order_detail_id);
        $detail->reason = $request->reason;
        $detail->save();

        return response()->json(['success' => true]);
    }

    public function wishlist()
    {
        $wishlists = ProductWishlist::get();
        return view('admin.wishlist.index', compact('wishlists'));
    }

    public function wishlist_remove($id)
    {
        $wishlist = ProductWishlist::find($id);

        if (!$wishlist) {
            return redirect()->back()->with('error', 'Wishlist item not found.');
        }

        $wishlist->delete();

        return redirect()->back()->with('success', 'Wishlist item removed successfully.');
    }


    public function notification()
    {
        // Get only unread notifications
        $nots = Notification::where('status', 1)->get();
        return view('admin.notification.index', compact('nots'));
    }



    public function viewAllNotifications()
    {
        $nots = Notification::where('status', 0)->get();
        Notification::where('status', 0)->update(['status' => 1]);

        return view('admin.notification.index', compact('nots'));
    }


    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if ($notification) {
            $notification->update(['status' => 1]);

            // Show only this notification
            $nots = collect([$notification]);

            return view('admin.notification.index', compact('nots'));
        }

        return redirect()->route('notifications.index')->with('error', 'Notification not found.');
    }


    public function notification_remove($id)
    {
        $nots = Notification::find($id);
        if (!$nots) {
            return redirect()->back()->with('error', 'Notification item not found.');
        }
        $nots->delete();
        return redirect()->back()->with('success', 'Notification item removed successfully.');
    }
}
