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

                                 <h4 class="header-title">{{ $deal ? 'Edit Get Inspired' : 'Create Get Inspired' }}</h4>

                                {{-- <a href="{{ route('get-inspired.index') }}" class="btn btn-primary">Manage Get Inspired</a> --}}

                            </div>

                        </div>

                        <div class="card-body">
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
                            <form method="POST" action="{{ route('get-inspired.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" id="title" name="title" class="form-control"
                                                value="{{ old('title', $deal->title ?? '') }}">
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status1" name="status" class="form-control form-select">
                                                <option value="1"
                                                    {{ old('status', $deal->status ?? '') == 1 ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0"
                                                    {{ old('status', $deal->status ?? '') == 0 ? 'selected' : '' }}>Deactive
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="detail" class="form-label">Detail</label>
                                            <textarea id="detail" name="detail" class="form-control" rows="4">{{ old('detail', $deal->detail ?? '') }}</textarea>
                                            @error('detail')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Image</label>
                                            <input type="file" id="image" name="image" class="form-control">
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror

                                            @if (!empty($deal->image))
                                                <div class="mt-2">
                                                    <img src="{{ asset('dealday/' . $deal->image) }}" alt="Get Inspired Image"
                                                        width="120">
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="">
                                            <button type="submit" class="btn btn-primary">
                                                {{ isset($deal) ? 'Update' : 'Submit' }}
                                            </button>
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

    <script>
        $(document).ready(function() {
            $('#category_id').change(function() {
                var categoryId = $(this).val();
                $('#product_id').html('<option value="">Select Product</option>');

                if (categoryId) {
                    $.ajax({
                        url: "{{ route('get-products', '') }}" + "/" +
                            categoryId,
                        type: 'GET',
                        success: function(response) {
                            $.each(response, function(key, product) {
                                $('#product_id').append('<option value="' + product.id +
                                    '">' + product.title + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection

