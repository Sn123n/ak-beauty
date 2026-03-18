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

                                <h4 class="header-title">Edit Banner</h4>

                                <a href="{{ route('banners.index') }}" class="btn btn-primary">Manage Banner</a>

                            </div>

                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('banners.update', $banner->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- Use PUT for updating -->
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Banner Name</label>
                                            <select id="name" name="name" class="form-control form-select">
                                                <option value="">Select Banner</option>
                                                <option value="contactus"
                                                    {{ $banner->name == 'contactus' ? 'selected' : '' }}>Contact Us</option>
                                                <option value="blog" {{ $banner->name == 'blog' ? 'selected' : '' }}>Blog
                                                </option>
                                                <option value="product" {{ $banner->name == 'product' ? 'selected' : '' }}>
                                                    Product</option>
                                                <option value="aboutus" {{ $banner->name == 'aboutus' ? 'selected' : '' }}>
                                                    About Us</option>
                                                <option value="category"
                                                    {{ $banner->name == 'category' ? 'selected' : '' }}>Category</option>
                                                <option value="dashboard"
                                                    {{ $banner->name == 'dashboard' ? 'selected' : '' }}>Dashboard</option>
                                                <option value="cart"
                                                    {{ $banner->name == 'cart' ? 'selected' : '' }}>Cart</option>
                                                <option value="wishlist"
                                                    {{ $banner->name == 'wishlist' ? 'selected' : '' }}>Wishlist</option>
                                                <option value="login"
                                                    {{ $banner->name == 'login' ? 'selected' : '' }}>Login</option>
                                                <option value="checkout"
                                                    {{ $banner->name == 'checkout' ? 'selected' : '' }}>Checkout</option>
                                                <option value="order"
                                                    {{ $banner->name == 'order' ? 'selected' : '' }}>Order</option>
                                                <option value="address"
                                                    {{ $banner->name == 'address' ? 'selected' : '' }}>Address</option>
                                                <option value="changepass"
                                                    {{ $banner->name == 'changepass' ? 'selected' : '' }}>Change Passwprd</option>
                                                <option value="acoountdetail"
                                                    {{ $banner->name == 'acoountdetail' ? 'selected' : '' }}> Acoount Detail</option>
                                                <option value="password"
                                                    {{ $banner->name == 'password' ? 'selected' : '' }}> Forgot Password</option>
                                                <option value="terms_condition"
                                                    {{ $banner->name == 'terms_condition' ? 'selected' : '' }}>Term & Condition</option>
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
                                            @if ($banner->image)
                                                <div class="mt-2">
                                                    <img src="{{ asset('/Banner/' . $banner->image) }}" alt="Banner Image"
                                                        width="150">
                                                </div>
                                            @endif
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status1" name="status" class="form-control form-select">
                                                <option value="1" {{ $banner->status == '1' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="0" {{ $banner->status == '0' ? 'selected' : '' }}>
                                                    Deactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
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
