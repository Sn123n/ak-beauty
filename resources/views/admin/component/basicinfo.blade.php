@extends('admin.layouts.header')

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">{{ $basicinfo ? 'Edit BasicInfo Us' : 'Create BasicInfo' }}</h4>
                        </div>

                        <div class="card-body basic">
                            @if (session('success'))
                                <div class="alert alert-success1" id="successMessage">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger" id="errorMessage">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('store.basicinfo') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">


                                    <!-- Additional Fields -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                value="{{ old('email', $basicinfo->email ?? '') }}">
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="phone_number" class="form-label">Phone Number</label>
                                            <input type="text" id="phone_number" name="phone_number" class="form-control"
                                                value="{{ old('phone_number', $basicinfo->phone_number ?? '') }}">
                                            @error('phone_number')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address Line1</label>
                                            <input type="text" id="address" name="address" class="form-control"
                                                value="{{ old('address', $basicinfo->address ?? '') }}">
                                            @error('address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="address2" class="form-label">Address Line2</label>
                                            <input type="text" id="address2" name="address2" class="form-control"
                                                value="{{ old('address2', $basicinfo->address2 ?? '') }}">
                                            @error('address2')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="site_name" class="form-label">Site Name</label>
                                            <input type="text" id="site_name" name="site_name" class="form-control"
                                                value="{{ old('site_name', $basicinfo->site_name ?? '') }}">
                                            @error('site_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="image_dark" class="form-label">Image Dark</label>
                                            <input type="file" id="image_dark" name="image_dark" class="form-control">
                                            <input type="hidden" name="old_image_dark"
                                                value="{{ $basicinfo->image_dark ?? '' }}">
                                            @if ($basicinfo && $basicinfo->image_dark)
                                                <img src="{{ asset('basicinfo/' . $basicinfo->image_dark) }}"
                                                    alt="Image" width="100">
                                            @endif
                                            @error('image_dark')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="image_light" class="form-label">Image Light</label>
                                            <input type="file" id="image_light" name="image_light" class="form-control">
                                            <input type="hidden" name="old_image_light"
                                                value="{{ $basicinfo->image_light ?? '' }}">
                                            @if ($basicinfo && $basicinfo->image_dark)
                                                <img src="{{ asset('basicinfo/' . $basicinfo->image_light) }}"
                                                    alt="Image" width="100">
                                            @endif

                                            @error('image_light')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <h4>Footer</h4>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="footer" class="form-label">Footer</label>
                                            <input class="form-control" id="footer" name="footer" rows="2"
                                                value="{{ old('footer', $basicinfo->footer ?? '') }}">
                                            @error('footer')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="font1" class="form-label">Footer Text1</label>
                                            <input type="text" id="font1" name="font1" class="form-control"
                                                value="{{ old('font1', $basicinfo->font1 ?? '') }}">
                                            @error('font1')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="font2" class="form-label">Footer Text2</label>
                                            <input type="text" id="font2" name="font2" class="form-control"
                                                value="{{ old('font2', $basicinfo->font2 ?? '') }}">
                                            @error('font2')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <h4>Social Media</h4>
                                    <!-- Social Media Links -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="facebook" class="form-label">Facebook</label>
                                            <input type="text" id="facebook" name="facebook" class="form-control"
                                                value="{{ old('facebook', $basicinfo->facebook ?? '') }}">
                                            @error('facebook')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="instagram" class="form-label">Instagram</label>
                                            <input type="text" id="instagram" name="instagram" class="form-control"
                                                value="{{ old('instagram', $basicinfo->instagram ?? '') }}">
                                            @error('instagram')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="thread" class="form-label">Thread</label>
                                            <input type="text" id="thread" name="thread" class="form-control"
                                                value="{{ old('thread', $basicinfo->thread ?? '') }}">
                                            @error('thread')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="pinterest" class="form-label">Pinterest</label>
                                            <input type="text" id="pinterest" name="pinterest" class="form-control"
                                                value="{{ old('pinterest', $basicinfo->pinterest ?? '') }}">
                                            @error('pinterest')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="twitter" class="form-label">Twitter</label>
                                            <input type="text" id="twitter" name="twitter" class="form-control"
                                                value="{{ old('twitter', $basicinfo->twitter ?? '') }}">
                                            @error('twitter')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-12">
                                        <button type="submit"
                                            class="btn btn-primary">{{ $basicinfo ? 'Update' : 'Create' }}</button>
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
@endsection
