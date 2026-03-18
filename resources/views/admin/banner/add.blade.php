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

                                <h4 class="header-title">Create Banner</h4>

                                <a href="{{ route('banners.index') }}" class="btn btn-primary">Manage Banner</a>

                            </div>

                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('banners.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-lg-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Banner Name</label>
                                            <select id="name" name="name" class="form-control form-select">
                                                <option value="">Select Banner</option>
                                                <option value="contactus"
                                                    {{ old('name') == 'contactus' ? 'selected' : '' }}>Contact Us</option>
                                                <option value="blog" {{ old('name') == 'blog' ? 'selected' : '' }}>Blog
                                                </option>
                                                <option value="product" {{ old('name') == 'product' ? 'selected' : '' }}>
                                                    Product</option>
                                                <option value="aboutus" {{ old('name') == 'aboutus' ? 'selected' : '' }}>
                                                    About Us</option>
                                                <option value="category" {{ old('name') == 'category' ? 'selected' : '' }}>
                                                    Category</option>
                                                <option value="dashboard"
                                                    {{ old('name') == 'dashboard' ? 'selected' : '' }}>
                                                    Dashboard</option>
                                                <option value="cart"
                                                    {{ old('name') == 'cart' ? 'selected' : '' }}>
                                                    Cart</option>
                                                <option value="wishlist"
                                                    {{ old('name') == 'wishlist' ? 'selected' : '' }}>
                                                    Wishlist</option>
                                                <option value="login"
                                                    {{ old('name') == 'login' ? 'selected' : '' }}>
                                                    Login</option>
                                                <option value="checkout"
                                                    {{ old('name') == 'checkout' ? 'selected' : '' }}>
                                                    Checkout</option>
                                                <option value="order"
                                                    {{ old('name') == 'order' ? 'selected' : '' }}>
                                                    Order</option>
                                                <option value="address"
                                                    {{ old('name') == 'address' ? 'selected' : '' }}>
                                                    Address</option>
                                                <option value="changepass"
                                                    {{ old('name') == 'changepass' ? 'selected' : '' }}>
                                                    Change Password</option>
                                                <option value="acoountdetail"
                                                    {{ old('name') == 'acoountdetail' ? 'selected' : '' }}>
                                                    Acoount Detail</option>
                                                <option value="password"
                                                    {{ old('name') == 'password' ? 'selected' : '' }}>
                                                    Forgot Password</option>
                                                <option value="terms_condition"
                                                    {{ old('name') == 'terms_condition' ? 'selected' : '' }}>
                                                    Term & Condition</option>
                                              
                                            </select>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Banner Image</label>
                                            <input type="file" id="image" name="image" class="form-control">
                                            <span class="size-notes">Note: size 1900(width) x 600(height)</span>
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label ">Status</label>
                                            <select id="status1" name="status" class="form-control form-select">
                                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                                    Deactive
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </form>
                        </div> <!-- end card-body -->

                    </div> <!-- end card -->

                </div><!-- end col -->

            </div><!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->

    @include('admin.layouts.footer')
@endsection
