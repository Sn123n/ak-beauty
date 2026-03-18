@extends('admin.layouts.header')

@section('content')
    <div class="content">

        <!-- Start Content-->

        <div class="container-fluid">



            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-header">

                            <div class="d-flex justify-content-between align-items-center">

                                <h4 class="header-title">Create SEO</h4>

                                <a href="{{ route('seo.index') }}" class="btn btn-primary">Manage SEO</a>

                            </div>

                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('seo.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                            
                                    <!-- Page name -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="page_name" class="form-label">Page Name</label>
                                            <select id="page_name" name="page_name" class="form-control form-select">
                                                <option value="">Select Page Name</option>
                                                {{-- <option value="admin_dashboard" {{ old('page_name') == 'admin_dashboard' ? 'selected' : '' }}>Admin Dashboard</option>
                                                <option value="admin_seo" {{ old('page_name') == 'admin_seo' ? 'selected' : '' }}>Admin Seo</option>
                                                <option value="admin_slider" {{ old('page_name') == 'admin_slider' ? 'selected' : '' }}>Admin Slider</option>
                                                <option value="admin_get_inspired" {{ old('page_name') == 'admin_get_inspired' ? 'selected' : '' }}>Admin Get Inspired</option>
                                                <option value="admin_jewellery" {{ old('page_name') == 'admin_jewellery' ? 'selected' : '' }}>Admin Online Jewellery Section</option>
                                                <option value="admin_marque" {{ old('page_name') == 'admin_marque' ? 'selected' : '' }}>Admin Marquee</option>
                                                <option value="admin_register_slider" {{ old('page_name') == 'admin_register_slider' ? 'selected' : '' }}>Admin Register Slider</option>
                                                <option value="admin_home_aboutus" {{ old('page_name') == 'admin_home_aboutus' ? 'selected' : '' }}>Admin Home AboutUs</option>
                                                <option value="admin_product_category" {{ old('page_name') == 'admin_product_category' ? 'selected' : '' }}>Admin Product Category</option>
                                                <option value="admin_product" {{ old('page_name') == 'admin_product' ? 'selected' : '' }}>Admin Product</option>
                                                <option value="admin_wishlist" {{ old('page_name') == 'admin_wishlist' ? 'selected' : '' }}>Admin Wishlist</option>
                                                <option value="admin_coupon" {{ old('page_name') == 'admin_coupon' ? 'selected' : '' }}>Admin Coupon</option>
                                                <option value="admin_pincode" {{ old('page_name') == 'admin_pincode' ? 'selected' : '' }}>Admin Pincode</option>
                                                <option value="admin_country" {{ old('page_name') == 'admin_country' ? 'selected' : '' }}>Admin Country</option>
                                                <option value="admin_state" {{ old('page_name') == 'admin_state' ? 'selected' : '' }}>Admin State</option>
                                                <option value="admin_city" {{ old('page_name') == 'admin_city' ? 'selected' : '' }}>Admin City</option>
                                                <option value="admin_orderlist" {{ old('page_name') == 'admin_orderlist' ? 'selected' : '' }}>Admin Order List</option>
                                                <option value="admin_order_detail" {{ old('page_name') == 'admin_order_detail' ? 'selected' : '' }}>Admin Order Detail</option>
                                                <option value="admin_user" {{ old('page_name') == 'admin_user' ? 'selected' : '' }}>Admin User</option>
                                                <option value="admin_aboutus" {{ old('page_name') == 'admin_aboutus' ? 'selected' : '' }}>Admin AboutUs</option>
                                                <option value="admin_banner" {{ old('page_name') == 'admin_banner' ? 'selected' : '' }}>Admin Banner</option>
                                                <option value="admin_blog_category" {{ old('page_name') == 'admin_blog_category' ? 'selected' : '' }}>Admin Blog Category</option>
                                                <option value="admin_blog" {{ old('page_name') == 'admin_blog' ? 'selected' : '' }}>Admin Blog</option>
                                                <option value="admin_contact_inquiry" {{ old('page_name') == 'admin_contact_inquiry' ? 'selected' : '' }}>Admin Contact Inquiry</option>
                                                <option value="admin_testimonial" {{ old('page_name') == 'admin_testimonial' ? 'selected' : '' }}>Admin Testimonial</option>
                                                <option value="admin_advertise" {{ old('page_name') == 'admin_advertise' ? 'selected' : '' }}>Admin Advertise</option>
                                                <option value="admin_basic_info" {{ old('page_name') == 'admin_basic_info' ? 'selected' : '' }}>Admin Basic Info</option>
                                                <option value="admin_edit_profile" {{ old('page_name') == 'admin_edit_profile' ? 'selected' : '' }}>Admin Edit Profile</option>
                                                <option value="admin_reset_password" {{ old('page_name') == 'admin_reset_password' ? 'selected' : '' }}>Admin Reset Password</option> --}}
                            
                                                <option value="user_home" {{ old('page_name') == 'user_home' ? 'selected' : '' }}>User Home Page</option>
                                                <option value="user_dashboard" {{ old('page_name') == 'user_dashboard' ? 'selected' : '' }}>User Dashboard</option>
                                                <option value="user_contactus" {{ old('page_name') == 'user_contactus' ? 'selected' : '' }}>User ContactUs</option>
                                                <option value="user_product" {{ old('page_name') == 'user_product' ? 'selected' : '' }}>User Product List</option>
                                                <option value="user_product_detail" {{ old('page_name') == 'user_product_detail' ? 'selected' : '' }}>User Product Detail</option>
                                                <option value="user_wishlist" {{ old('page_name') == 'user_wishlist' ? 'selected' : '' }}>User Wishlist</option>
                                                <option value="user_cart" {{ old('page_name') == 'user_cart' ? 'selected' : '' }}>User Cart</option>
                                                <option value="user_checkout" {{ old('page_name') == 'user_checkout' ? 'selected' : '' }}>User Checkout</option>
                                                <option value="user_category" {{ old('page_name') == 'user_category' ? 'selected' : '' }}>User Category List</option>
                                                <option value="user_aboutus" {{ old('page_name') == 'user_aboutus' ? 'selected' : '' }}>User AboutUs</option>
                                                <option value="user_blog" {{ old('page_name') == 'user_blog' ? 'selected' : '' }}>User Blog</option>
                                                <option value="user_blog_detail" {{ old('page_name') == 'user_blog_detail' ? 'selected' : '' }}>User Blog Detail</option>
                                                <option value="user_login" {{ old('page_name') == 'user_login' ? 'selected' : '' }}>User Login Page</option>
                                                <option value="user_register" {{ old('page_name') == 'user_register' ? 'selected' : '' }}>User Register Page</option>
                                                <option value="user_forgot_password_link" {{ old('page_name') == 'user_forgot_password' ? 'selected' : '' }}>User Forgot Password Link </option>
                                                <option value="user_forgot_password" {{ old('page_name') == 'user_forgot_password' ? 'selected' : '' }}>User Forgot Password</option>
                                                <option value="user_reset_password" {{ old('page_name') == 'user_reset_password' ? 'selected' : '' }}>User Reset Password</option>
                                                <option value="user_order_history" {{ old('page_name') == 'user_order_history' ? 'selected' : '' }}>User Order History</option>
                                                <option value="user_order_detail" {{ old('page_name') == 'user_order_detail' ? 'selected' : '' }}>User Order Detail</option>
                                                <option value="user_address" {{ old('page_name') == 'user_address' ? 'selected' : '' }}>User Address</option>
                                                <option value="user_edit_profile" {{ old('page_name') == 'user_edit_profile' ? 'selected' : '' }}>User Edit Profile</option>
                                                <option value="user_order_success" {{ old('page_name') == 'user_order_success' ? 'selected' : '' }}>User Order Success</option>
                                                <option value="terms_condition" {{ old('page_name') == 'terms_condition' ? 'selected' : '' }}>Term & Condition</option>
                                                <option value="privacy_policy" {{ old('page_name') == 'privacy_policy' ? 'selected' : '' }}>Privacy Policy</option>
                                            </select>
                                            @error('page_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- Meta Title -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="meta_title" class="form-label">Meta Title</label>
                                            <input type="text" id="meta_title" name="meta_title" class="form-control"
                                                value="{{ old('meta_title') }}">
                                            @error('meta_title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- Meta Keywords -->
                                    <div class="col-lg-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="meta_keywords" class="form-label">Meta Keyword</label>
                                            <textarea type="text" id="meta_keywords" name="meta_keywords" class="form-control"
                                                value="">{{ old('meta_keywords') }}</textarea>
                                            @error('meta_keywords')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- Meta Description -->
                                    <div class="col-lg-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="meta_description" class="form-label">Meta Description</label>
                                            <textarea class="form-control" name="meta_description" rows="3"
                                                placeholder="Enter meta_description">{{ old('meta_description') }}</textarea>
                                            @error('meta_description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- Submit Button -->
                                    <div class="col-lg-12">
                                        <div class="">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                            
                                </div> <!-- end row -->
                            </form>
                            

                        </div> <!-- end card-body -->

                    </div> <!-- end card -->

                </div><!-- end col -->

            </div><!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->

    @include('admin.layouts.footer')

@endsection
