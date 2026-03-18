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

                                <h4 class="header-title">Reset Password</h4>

                            </div>

                        </div>

                        <div class="card-body">

                            <form action="{{ route('password.update') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="mb-3">
                                            <label for="old_password" class="form-label">Old Password</label>
                                            <input type="password" id="old_password" name="old_password"
                                                class="form-control">
                                            @error('old_password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">New Password</label>
                                            <input type="password" id="password" name="password" class="form-control">
                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <input type="password" id="password_confirmation" name="password_confirmation"
                                                class="form-control">
                                            @error('password_confirmation')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="">
                                            <button type="submit" class="btn btn-primary">Reset Password</button>
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
