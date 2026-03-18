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

                                <h4 class="header-title">Create Pincode</h4>

                                <a href="{{ route('pincode.index') }}" class="btn btn-primary">Manage Pincode</a>

                            </div>

                        </div>

                        <div class="card-body">

                            <form method="POST"
                                action="{{ isset($pincode) ? route('pincode.update', $pincode->id) : route('pincode.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @if (isset($pincode))
                                    @method('PATCH')
                                @endif
                                <div class="row">

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="country_name" class="form-label ">Pincode</label>
                                            <input type="text" class="form-control" id="pincode" name="pincode"
                                                placeholder="Enter Pincode"
                                                value="{{ old('pincode', isset($pincode) ? $pincode->pincode : '') }}">
                                            @error('pincode')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="state_name" class="form-label">City</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                placeholder="Enter City"
                                                value="{{ old('city', isset($pincode) ? $pincode->city : '') }}">
                                            @error('city')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">State</label>
                                            <input type="text" class="form-control" id="state" name="state"
                                                placeholder="Enter State"
                                                value="{{ old('state', isset($pincode) ? $pincode->state : '') }}">
                                            @error('state')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label ">Price</label>
                                            <input type="text" class="form-control" id="price" name="price"
                                                placeholder="Enter Price"
                                                value="{{ old('price', isset($pincode) ? $pincode->price : '') }}">
                                            @error('price')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
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
