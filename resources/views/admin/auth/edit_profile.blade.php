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
                                <h4 class="header-title">Edit Profile</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success1" id="successMessage">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form id="editUserForm" method="POST" action="{{ route('update.profile', $user->id) }}"
                                enctype="multipart/form-data">

                                @csrf

                                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Username</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                value="{{ $user->name }}">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                value="{{ $user->email }}">
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
									<div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input id="address" name="address" class="form-control" value="{{ $user->address }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="text" id="phone" name="phone" class="form-control"
                                                value="{{ old('weight_in_gram', $user->phone) }}">
                                            @error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Profile Image</label>
                                            <input type="file" id="image" name="image" class="form-control">
                                            @if ($user->image)
                                                <img src="{{ asset('profile/' . $user->image) }}" alt="Profile Image"
                                                    width="100" class="mt-2">
                                                @error('image')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12">
                                        <div class="">
                                            <button type="submit" class="btn btn-primary">Update Profile</button>
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
    <script>
        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 3000);
    </script>
    <script>
        new DataTable('#example', {

            responsive: true, // Enables responsiveness overall

            breakpoints: [

                {
                    name: 'tablet',
                    width: 1024
                },

                {
                    name: 'fablet',
                    width: 768
                },

                {
                    name: 'phone',
                    width: 480
                }

            ]

        });
    </script>
@endsection
