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

                            <form method="POST" action="{{ route('seo.update', $seo->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                            
                                    {{-- Page Name Dropdown --}}
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="page_name" class="form-label">Page Name</label>
                                            <select id="page_name" name="page_name" class="form-control form-select">
                                                <option value="">Select Page Name</option>
                                                @php
                                                    $pages = [
                                                        // 'admin_dashboard' => 'Admin Dashboard',
                                                        // 'admin_seo' => 'Admin Seo',
                                                        // 'admin_slider' => 'Admin Slider',
                                                        // 'admin_get_inspired' => 'Admin Get Inspired',
                                                        // 'admin_jewellery' => 'Admin Online Jewellery Section',
                                                        // 'admin_marque' => 'Admin Marquee',
                                                        // 'admin_register_slider' => 'Admin Register Slider',
                                                        // 'admin_home_aboutus' => 'Admin Home AboutUs',
                                                        // 'admin_product_category' => 'Admin Product Category',
                                                        // 'admin_product' => 'Admin Product',
                                                        // 'admin_wishlist' => 'Admin Wishlist',
                                                        // 'admin_coupon' => 'Admin Coupon',
                                                        // 'admin_pincode' => 'Admin Pincode',
                                                        // 'admin_country' => 'Admin Country',
                                                        // 'admin_state' => 'Admin State',
                                                        // 'admin_city' => 'Admin City',
                                                        // 'admin_orderlist' => 'Admin Order List',
                                                        // 'admin_order_detail' => 'Admin Order Detail',
                                                        // 'admin_user' => 'Admin User',
                                                        // 'admin_aboutus' => 'Admin AboutUs',
                                                        // 'admin_banner' => 'Admin Banner',
                                                        // 'admin_blog_category' => 'Admin Blog Category',
                                                        // 'admin_blog' => 'Admin Blog',
                                                        // 'admin_contact_inquiry' => 'Admin Contact Inquiry',
                                                        // 'admin_testimonial' => 'Admin Testimonial',
                                                        // 'admin_advertise' => 'Admin Advertise',
                                                        // 'admin_basic_info' => 'Admin Basic Info',
                                                        // 'admin_edit_profile' => 'Admin Edit Profile',
                                                        // 'admin_reset_password' => 'Admin Reset Password',
                            
                                                        'user_home' => 'User Home Page',
                                                        'user_dashboard' => 'User Dashboard',
                                                        'user_contactus' => 'User ContactUs',
                                                        'user_product' => 'User Product List',
                                                        'user_product_detail' => 'User Product Detail',
                                                        'user_wishlist' => 'User Wishlist',
                                                        'user_cart' => 'User Cart',
                                                        'user_checkout' => 'User Checkout',
                                                        'user_category' => 'User Category List',
                                                        'user_aboutus' => 'User AboutUs',
                                                        'user_blog' => 'User Blog',
                                                        'user_blog_detail' => 'User Blog Detail',
                                                        'user_login' => 'User Login Page',
                                                        'user_register' => 'User Register Page',
                                                        'user_forgot_password' => 'User Forgot Password',
                                                        'user_reset_password' => 'User Reset Password',
                                                        'user_order_history' => 'User Order History',
                                                        'user_order_detail' => 'User Order Detail',
                                                        'user_address' => 'User Address',
                                                        'user_edit_profile' => 'User Edit Profile',
                                                        'user_order_success' => 'User Order Success',
                                                        'terms_condition' => 'Term & Condition',
                                                        'privacy_policy' => 'Privacy Policy'
                                                    ];
                                                @endphp
                            
                                                @foreach ($pages as $value => $label)
                                                    <option value="{{ $value }}" {{ old('page_name', $seo->page_name) == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('page_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    {{-- Meta Title --}}
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="meta_title" class="form-label">Meta Title</label>
                                            <input type="text" id="meta_title" name="meta_title" class="form-control"
                                                value="{{ old('meta_title', $seo->meta_title) }}">
                                            @error('meta_title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    {{-- Meta Keywords --}}
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="meta_keywords" class="form-label">Meta Keyword</label>
                                            <textarea type="text" id="meta_keywords" name="meta_keywords" class="form-control"
                                                value="">{{ old('meta_keywords', $seo->meta_keywords) }}</textarea>
                                            @error('meta_keywords')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    {{-- Meta Description --}}
                                    <div class="col-lg-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="meta_description" class="form-label">Meta Description</label>
                                            <textarea class="form-control" name="meta_description" rows="3"
                                                placeholder="Enter meta_description">{{ old('meta_description', $seo->meta_description) }}</textarea>
                                            @error('meta_description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    {{-- Submit Button --}}
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                            
                            

                        </div> <!-- end card-body -->

                    </div> <!-- end card -->

                </div><!-- end col -->

            </div><!-- end row -->





        </div> <!-- container -->



    </div> <!-- content -->

    @include('admin.layouts.footer')

@endsection
