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

                                <h4 class="header-title">Create Contact Inquiry</h4>

                                <a href="{{ route('contactus') }}" class="btn btn-primary">Manage Contact Inquiry</a>

                            </div>

                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('contactus.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                            
                                    <!-- Title -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- Category -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Email</label>
                                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- Date -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="number" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
                                            @error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status1" name="status" class="form-control form-select">
                                                <option value="1">Active</option>
                                                <option value="0">Deactive</option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- Content -->
                                    <div class="col-lg-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="message" class="form-label">Message</label>
                                            <textarea class="form-control"  name="message" rows="3" placeholder="Enter message">{{ old('message') }}</textarea>
                                            @error('message')
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
