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

                                <h4 class="header-title">Add User</h4>

                                <a href="{{ route('users.index') }}" class="btn btn-primary">Manage User</a>

                            </div>

                        </div>

                        <div class="card-body">

                            <form action="{{ route('users.update', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="role_id" id="role_id" value="{{ $user->role_id }}">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" id="email" name="email" class="form-control"
                                                value="{{ old('email', $user->email) }}">
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                value="{{ old('name', $user->name) }}">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Mobile</label>
                                            <input type="text" id="phone" name="phone" class="form-control"
                                                value="{{ old('phone', $user->phone) }}">
                                            @error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">

                                        <div class="mb-3">

                                            <label for="moblie" class="form-label">Gender</label>

                                            <select id="gender" name="gender" class="form-control form-select">
                                                <option value="1"
                                                    {{ old('gender', $user->gender) == '1' ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="0"
                                                    {{ old('gender', $user->gender) == '0' ? 'selected' : '' }}>
                                                    Female</option>
                                            </select>
                                            @error('gender')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="moblie" class="form-label">Date Of Birth</label>

                                            <input type="date" id="dob" name="dob" class="form-control"
                                                value="{{ old('dob', $user->dob) }}">
                                            @error('dob')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Country</label>
                                            <select name="country" id="country_name" class="form-control form-select">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->location_id }}"
                                                        {{ $country->location_id == old('country', $selectedCountry ?? '') ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('country')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="state" class="form-label">State</label>
                                            <select class="form-control form-select" id="state_name" name="state">
                                                <option value="">Select State</option>
                                            </select>
                                            @error('state')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="city" class="form-label">City</label>
                                            <select class="form-control form-select" id="city_name" name="city">
                                                <option value="">Select City</option>
                                            </select>
                                            @error('city')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="pincode" class="form-label">Pincode </label>
                                            <input type="text" id="pincode" name="pincode" class="form-control"
                                                value="{{ old('pincode', $user->pincode) }}">
                                            @error('pincode')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea class="form-control" name="address" id="address">{{ old('address', $user->address) }}</textarea>
                                            @error('address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Image</label>
                                            <input type="file" id="image" name="image" class="form-control">
                                            @if ($user->image)
                                                <img src="{{ asset('user/' . $user->image) }}" alt="User Image"
                                                    width="100">
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
                                                <option value="1"
                                                    {{ old('status', $user->status) == '1' ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0"
                                                    {{ old('status', $user->status) == '0' ? 'selected' : '' }}>
                                                    Deactive</option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
            // Get the old or preselected values from the view variables
            var selectedCountry = "{{ old('country', $selectedCountry ?? '') }}";
            var selectedState = "{{ old('state', $selectedState ?? '') }}";
            var selectedCity = "{{ old('city', $selectedCity ?? '') }}";

            function fetchStates(country_id, selectedState) {
                if (country_id) {
                    $.ajax({
                        url: "{{ route('fetch_states_by_country') }}",
                        method: 'GET',
                        data: {
                            country_id: country_id
                        },
                        success: function(response) {
                            $('#state_name').empty().append('<option value="">Select State</option>');
                            $('#city_name').empty().append('<option value="">Select City</option>')
                                .prop('disabled', true);

                            response.states.forEach(function(state) {
                                $('#state_name').append('<option value="' + state.location_id +
                                    '"' +
                                    (state.location_id == selectedState ? ' selected' :
                                    '') + '>' + state.name + '</option>');
                            });

                            $('#state_name').prop('disabled', false);

                            if (selectedState) {
                                fetchCities(selectedState, selectedCity);
                            }
                        }
                    });
                } else {
                    $('#state_name').empty().append('<option value="">Select State</option>').prop('disabled',
                    true);
                    $('#city_name').empty().append('<option value="">Select City</option>').prop('disabled', true);
                }
            }

            function fetchCities(state_id, selectedCity) {
                if (state_id) {
                    $.ajax({
                        url: "{{ route('fetch_cities_by_state') }}",
                        method: 'GET',
                        data: {
                            state_id: state_id
                        },
                        success: function(response) {
                            $('#city_name').empty().append('<option value="">Select City</option>');

                            response.cities.forEach(function(city) {
                                $('#city_name').append('<option value="' + city.location_id +
                                    '"' +
                                    (city.location_id == selectedCity ? ' selected' : '') +
                                    '>' + city.name + '</option>');
                            });

                            $('#city_name').prop('disabled', false);
                        }
                    });
                } else {
                    $('#city_name').empty().append('<option value="">Select City</option>').prop('disabled', true);
                }
            }

            $('#country_name').on('change', function() {
                fetchStates($(this).val(), '');
            });

            $('#state_name').on('change', function() {
                fetchCities($(this).val(), '');
            });

            // Preload states and cities if country is already selected (edit form)
            if (selectedCountry) {
                fetchStates(selectedCountry, selectedState);
            }
        });
    </script>
@endsection
