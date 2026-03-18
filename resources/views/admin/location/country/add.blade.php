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

                                <h4 class="header-title">Create Country</h4>

                                <a href="{{ route('countries.index') }}" class="btn btn-primary">Manage Country</a>

                            </div>

                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('countries.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                value="{{ old('name') }}">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label ">Status</label>
                                            <select id="status1" name="status" class="form-control form-select">
                                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Deactive
                                                </option>
                                            </select>
                                            @error('status')
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
