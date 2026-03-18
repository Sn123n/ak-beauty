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

                                <h4 class="header-title">Create State</h4>

                                <a href="{{ route('state.index') }}" class="btn btn-primary">Manage State</a>

                            </div>

                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('state.update', $state->location_id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                            
                                    <!-- Country Dropdown -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="country_name" class="form-label">Country</label>
                                            <select name="country_name" id="country_name" class="form-control form-select">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->location_id }}" {{ old('country_name', $state->parent_id) == $country->location_id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('country_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- State Name Input -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="state_name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="state_name" name="state_name" placeholder="Enter State Name" value="{{ old('state_name', $state->name) }}">
                                            @error('state_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- Status Dropdown -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status1" name="status" class="form-control form-select">
                                                <option value="0" {{ old('status', $state->status) == '0' ? 'selected' : '' }}>Active</option>
                                                <option value="1" {{ old('status', $state->status) == '1' ? 'selected' : '' }}>Deactive</option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- Submit Button -->
                                    <div class="col-lg-12">
                                        <div>
                                            <button type="submit" class="btn btn-primary">Update</button>
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
