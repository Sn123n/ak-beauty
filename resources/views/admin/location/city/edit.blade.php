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

                                <h4 class="header-title">Create City</h4>

                                <a href="{{ route('cities.index') }}" class="btn btn-primary">Manage City</a>

                            </div>

                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('cities.update', $city->location_id ?? '') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- Important for updating records -->

                                <div class="row">
                                    <!-- Country Dropdown -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="country_name" class="form-label">Country</label>
                                            <select name="country_name" id="country_name" class="form-control form-select">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->location_id }}"
                                                        {{ old('country_name', $city->parent->parent_id ?? '') == $country->location_id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('country_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- State Dropdown -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="state_name" class="form-label">State</label>
                                            <select class="form-control form-select" id="state_name" name="state_name">
                                                <option value="">Select State</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->location_id }}"
                                                        {{ old('state_name', $city->parent_id ?? '') == $state->location_id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('state_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- City Name Input -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="city_name" class="form-label">City Name</label>
                                            <input type="text" class="form-control" id="city_name" name="city_name"
                                                placeholder="Enter City Name"
                                                value="{{ old('city_name', $city->name ?? '') }}">
                                            @error('city_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Status Dropdown -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status1" name="status" class="form-control form-select">
                                                <option value="0"
                                                    {{ old('status', $city->status ?? '') == '0' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="1"
                                                    {{ old('status', $city->status ?? '') == '1' ? 'selected' : '' }}>
                                                    Deactive</option>
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
        $(document).ready(function() {
            // alert(111);
            $('#country_name').on('change', function() {

                var country_id = $(this).val();

                if (country_id) {
                    $.ajax({
                        url: "{{ route('fetch_states_by_country') }}", // FIXED: Wrapped in quotes
                        method: 'GET',
                        data: {
                            country_id: country_id
                        },
                        success: function(response) {
                            var stateDropdown = $('#state_name');
                            stateDropdown.empty();
                            stateDropdown.append('<option value="">Select State</option>');

                            response.states.forEach(function(state) {
                                stateDropdown.append('<option value="' + state
                                    .location_id + '">' + state.name + '</option>');
                            });
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText); // Debugging in case of errors
                        }
                    });
                }
            });
        });
    </script>
@endsection
