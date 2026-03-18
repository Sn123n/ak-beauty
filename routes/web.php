<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ForgotpasswordController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\PincodeController;
use App\Http\Controllers\Admin\GetInspiredController;
use App\Http\Controllers\Admin\FrenchManicureController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\TermConditionController;
use App\Http\Controllers\Admin\FooterIconController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\UserForgotPasswordController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MailController;


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('backpanel')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/checklogin', [AdminController::class, 'login_check'])->name('checklogin');

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        Route::get('/add_user', [AdminController::class, 'adduser'])->name('add_user');
        Route::get('/manaage_user', [AdminController::class, 'Manageuser'])->name('manaage_user');
        Route::get('/edit-profile', [AdminController::class, 'editprofile'])->name('edit.profile');
        Route::post('updateprofile/{id}', [AdminController::class, 'updateprofile'])->name('update.profile');

        // reset password
        Route::get('/reset-password', [ForgotpasswordController::class, 'chnagepass'])->name('reset.password');
        Route::post('/password/update', [ForgotpasswordController::class, 'resetPassword'])->name('password.update');

        Route::resource('seo', SeoController::class);
        Route::resource('countries', CountryController::class);
        Route::resource('state', StateController::class);
        Route::resource('cities', CityController::class);
        Route::resource('pincode', PincodeController::class);
        Route::get('/fetch-states-by-country', [CityController::class, 'fetchStatesByCountry'])->name('fetch_states_by_country');
        Route::get('/fetch-cities-by-state', [CityController::class, 'fetchCitiesByState'])->name('fetch_cities_by_state');
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('get-inspired', GetInspiredController::class);
        Route::get('/get-products/{category_id}', [GetInspiredController::class, 'getProducts'])->name('get-products');
        Route::post('/update-displayhome-status', [CategoryController::class, 'updatedisplay_on_home'])->name('displayhome.status');

        Route::resource('sliders', SliderController::class);
        Route::resource('testimonial', TestimonialController::class);
        Route::resource('footer-icon', FooterIconController::class);
        Route::resource('products', ProductController::class);
        Route::resource('coupons', CouponController::class);
        Route::delete('/product/delete-image', [ProductController::class, 'deleteImage'])->name('product.deleteImage');
        Route::post('/update-dailydeal-status', [ProductController::class, 'updateDailyDealStatus'])->name('update.dailydeal.status');
        Route::post('/updatecountry-status', [CountryController::class, 'updateStatus'])->name('updatecountry.status');
        Route::post('/check-email', [UserController::class, 'checkEmail'])->name('checkemail');

        Route::get('home-product-create', [FrenchManicureController::class, 'create'])->name('home-product.create');
        Route::match(['post', 'put'], 'storehome-product/{id?}', [FrenchManicureController::class, 'store'])->name('storehome-product');


        Route::post('/update-status', [HomeController::class, 'updateStatus'])->name('update.status');

        Route::get('/aboutus', [HomeController::class, 'aboutus'])->name('aboutus');
        Route::post('/storeaboutus', [HomeController::class, 'storeaboutus'])->name('store.aboutus');
        Route::get('/nail-extension', [HomeController::class, 'nailextenation'])->name('nailextenation');
        Route::post('/storenailextenation', [HomeController::class, 'storenailextenation'])->name('store.nailextenation');
        Route::get('/basicinfo', [HomeController::class, 'basicinfo'])->name('basicinfo');
        Route::post('/storebasicinfo', [HomeController::class, 'storeOrUpdatebasicinfo'])->name('store.basicinfo');
        Route::get('/contactus', [HomeController::class, 'contactus'])->name('contactus');
        Route::get('/contactusdetail', [HomeController::class, 'contactusdetail'])->name('contactus.detail');
        Route::delete('/contactus-delete/{contact}', [HomeController::class, 'contactusdestroy'])->name('contactus.destroy');

        Route::get('/order_list', [AdminController::class, 'OrderListing'])->name('order_list');
        Route::get('/view-order-detail/{id}', [AdminController::class, 'orderdetail'])->name('view.order');

        Route::get('/wishlist', [AdminController::class, 'wishlist'])->name('wishlist');
        Route::delete('/removewishlist/{id}', [AdminController::class, 'wishlist_remove'])->name('wishlist_remove');


        Route::delete('/order-delete/{order}', [AdminController::class, 'deleteorder'])->name('order.delete');
        Route::delete('/orderdetail-delete/{id}', [AdminController::class, 'deleteorderdetail'])->name('orderdetail.delete');
        Route::post('/order/update-status', [AdminController::class, 'updateStatus'])->name('order.updateStatus');
        Route::post('/orders/set-estimated-date', [AdminController::class, 'setEstimatedDate'])->name('orders.setEstimatedDate');
        Route::post('/orders/savereason', [AdminController::class, 'savereason'])->name('orders.savereason');

        Route::get('/product-review', [ProductController::class, 'reviewlist'])->name('review.list');
        Route::get('/filter-review/{id}', [ProductController::class, 'reviewFilterList'])->name('reviewfilter.list');
        Route::delete('/product-review-delete/{review}', [ProductController::class, 'deletereview'])->name('review.delete');

        Route::get('/notifications', [AdminController::class, 'notification'])->name('notifications.index');
        Route::get('/notifications/mark/{id}', [AdminController::class, 'markAsRead'])->name('notifications.mark');
        Route::get('/notifications/view-all', [AdminController::class, 'viewAllNotifications'])->name('notifications.viewAll');
        Route::delete('/notification_remove/{id}', [AdminController::class, 'notification_remove'])->name('notification_remove');

        Route::get('/term-condition', [TermConditionController::class, 'TermCondition'])->name('term_condition');
        Route::post('/store-term_condition', [TermConditionController::class, 'storeTermCondition'])->name('store.term_condition');
        Route::get('/privacy-policy', [TermConditionController::class, 'privacypolicy'])->name('privacypolicy');
        Route::post('/store-privacypolicy', [TermConditionController::class, 'storeprivacypolicy'])->name('store.privacypolicy');
        Route::get('/shipping-policy', [TermConditionController::class, 'shippingpolicy'])->name('shippingpolicy');
        Route::post('/store-shippingpolicy', [TermConditionController::class, 'shippingpolicystore'])->name('store.shippingpolicy');
        Route::get('/refund-policy', [TermConditionController::class, 'refundpolicy'])->name('refundpolicy');
        Route::post('/store-refundpolicy', [TermConditionController::class, 'refundpolicystore'])->name('store.refundpolicy');
    });
});

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('user.dashboard');
    Route::post('/profile/update', [DashboardController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/address/get/{id}', [DashboardController::class, 'getAddress'])->name('user.address.get');
    Route::post('/address/store', [DashboardController::class, 'storeAddress'])->name('user.address.store');
    Route::post('/address/update/{id}', [DashboardController::class, 'updateUserAddress'])->name('user.address.update.id');
    Route::delete('/address/delete/{id}', [DashboardController::class, 'deleteAddress'])->name('user.address.delete');
    Route::get('/order-list', [DashboardController::class, 'orderlist'])->name('user.order');
    Route::get('/order-detail/{id}', [DashboardController::class, 'orderDetails'])->name('order.details');
    Route::get('/account-detail', [DashboardController::class, 'account_detail'])->name('user.acountdetail');
    Route::put('/account/update/{id}', [DashboardController::class, 'updateaccount'])->name('account.update');
    Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('user.logout');
    
    // Location routes for frontend users
    Route::get('/fetch-states-by-country', [DashboardController::class, 'fetchStatesByCountry'])->name('user.fetch_states_by_country');
    Route::get('/fetch-cities-by-state', [DashboardController::class, 'fetchCitiesByState'])->name('user.fetch_cities_by_state');
});
Route::get('/about-ak-beauty', [IndexController::class, 'aboutus'])->name('user.aboutus');
Route::get('/nail-extention', [IndexController::class, 'nail_extention'])->name('nail_extention');
Route::get('/blog-details/{id}', [IndexController::class, 'blogdetail'])->name('blog.details');
Route::get('/contact-us', [IndexController::class, 'contactus'])->name('user.contactus');
Route::get('/terms-condition', [IndexController::class, 'terms'])->name('user.term_condition');
Route::get('/privacy-policy', [IndexController::class, 'privacypolicy'])->name('user.privacypolicy');
Route::get('/shipping-policy', [IndexController::class, 'shipping_policy'])->name('user.shipping_policy');
Route::get('/refund-policy', [IndexController::class, 'refund_policy'])->name('user.refund_policy');
Route::get('products', [DashboardController::class, 'productlist'])->name('product.list');

Route::post('/storecontactus', [IndexController::class, 'storecontactus'])->name('contactus.store');

Route::get('/address', [DashboardController::class, 'address'])->name('user.address');
Route::post('/update-user-address', [DashboardController::class, 'updateaddress'])->name('user.address.update');
Route::post('/user-address', [DashboardController::class, 'updatebillingaddress'])->name('user.billing.address');

Route::get('/chnage-password', [DashboardController::class, 'change_password'])->name('user.change_password');
Route::post('/update_password', [DashboardController::class, 'update_password'])->name('update.password');

Route::get('/checkout', [DashboardController::class, 'checkout'])->name('checkout.view');
Route::get('/getShippingCharge', [OrderController::class, 'getShippingCharge'])->name('get.shipping.charge');
Route::get('/check-pincode', [OrderController::class, 'checkPincode'])->name('check.pincode');
Route::post('/place/order', [OrderController::class, 'placeOrder'])->name('place.order');
Route::get('/order-confirm/{orderId}', [OrderController::class, 'order_confirm'])->name('order_confirm.order');



Route::get('products-details/{id}', [DashboardController::class, 'productdetail'])->name('product.detail');
Route::post('/products/maxPrice', [DashboardController::class, 'getMaxPrice'])->name('products.maxPrice');
Route::get('/get-products-by-category', [DashboardController::class, 'getProductsByCategory'])->name('products.filter');
Route::get('category', [DashboardController::class, 'category'])->name('category.list');
Route::post('/reviews/store', [DashboardController::class, 'storereview'])->name('reviews.store');
Route::get('/get-min-price', [DashboardController::class, 'getMinPrice'])->name('products.minPrice');


Route::post('/wishlist/add', [WishlistController::class, 'store'])->name('wishlist.add');
Route::post('/wishlist/remove', [WishlistController::class, 'destroy'])->name('wishlist.remove');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('/wishlist-count', [WishlistController::class, 'wishlistCount'])->name('wishlist.count');
Route::post('/moveto-wishlist', [WishlistController::class, 'moveToWishlist'])->name('move.to.wishlist');

Route::post('/add-to-cart', [DashboardController::class, 'addToCart'])->name('add.to.cart');
Route::post('/add-to-cartdetail', [DashboardController::class, 'addToCartDetailpage'])->name('add.to.cartdetail');
Route::post('/update-to-cart', [DashboardController::class, 'updateToCart'])->name('update.to.cart');
Route::post('/remove-from-cart', [DashboardController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart', [DashboardController::class, 'cart'])->name('cart.view');
Route::get('/getcoupon', [DashboardController::class, 'getcoupon'])->name('get.coupon');
Route::post('/validate-coupon', [DashboardController::class, 'validateCoupon'])->name('validate.coupon');
Route::post('/apply-coupon', [DashboardController::class, 'applyCoupon'])->name('apply.coupon');
Route::get('/cart-count', [DashboardController::class, 'getCartCount'])->name('cart.count');
Route::get('/cart/view', [DashboardController::class, 'getcart'])->name('cart.viewmodel');
Route::post('/cart/update', [DashboardController::class, 'update'])->name('cart.update');

Route::get('/login', [LoginController::class, 'login'])->name('user.login');

Route::get('/register', [LoginController::class, 'register'])->name('user.register');
Route::post('/logincheck', [LoginController::class, 'check_login'])->name('check_login');
Route::post('/send-login-otp', [LoginController::class, 'sendLoginOtp'])->name('send.login.otp');
Route::post('/verify-login-otp', [LoginController::class, 'verifyLoginOtp'])->name('verify.login.otp');

Route::get('/forgot-password', [UserForgotPasswordController::class, 'forgot_password'])->name('forgot-password');
Route::post('/forgot-password-check', [UserForgotPasswordController::class, 'forgot_password_check'])->name('forgot_password_check');
Route::get('/reset-password/{id}', [UserForgotPasswordController::class, 'reset_password'])->name('reset_password');
Route::post('/reset-password-check', [UserForgotPasswordController::class, 'reset_password_check'])->name('reset_password_check');


Route::post('/send-otp', [OtpController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [OtpController::class, 'verifyOtpAndRegister'])->name('verify.otp');
Route::post('/check-email', [OtpController::class, 'checkEmail'])->name('check.email');
Route::post('/resend-otp', [OtpController::class, 'resendOtp']);

Route::get('/get-register-slider', [LoginController::class, 'getRegisterSlider'])->name('get.slider');

// search product
Route::get('/search-products', [DashboardController::class, 'search'])->name('search.product');


Route::get('/clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    Artisan::call('view:clear');
    Session::flush();
    return "Cache cleared successfully";
});


Route::get('/test-email', function () {
    \Illuminate\Support\Facades\Mail::raw('This is a test email', function ($message) {
        $message->to('sunita@yopmail.com')
            ->subject('Test Email');
    });

    return 'Email sent successfully!';
});
Route::get('send-mail', [MailController::class, 'index']);



Route::get('/send-hello-mail', function () {
    try {
        Mail::raw('Hello', function ($message) {
            $message->to('arya.developers.2017@gmail.com') // change to actual recipient
                ->subject('Test Mail');
        });

        return 'Mail Sent!';
    } catch (\Exception $e) {
        // Log the error (optional)
        dd('Mail sending failed: ' . $e->getMessage());

        // Return error response
        // return 'Mail failed: ' . $e->getMessage();
    }
});
