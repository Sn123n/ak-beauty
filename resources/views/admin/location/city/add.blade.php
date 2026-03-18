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

                            <form method="POST" action="{{ route('cities.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="country_name" class="form-label ">Country</label>
                                            <select name="country_name" id="country_name" class="form-control form-select">

                                                <option value="">Select Country</option>

                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->location_id }}"
                                                        {{ old('country_name', isset($state) ? $state->parent_id : '') == $country->location_id ? 'selected' : '' }}>

                                                        {{ $country->name }}

                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('country_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="state_name" class="form-label">State</label>
                                            <select class="form-control form-select" id="state_name" name="state_name">
                                                <option value="">Select State</option>
                                            </select>

                                            </select>
                                            @error('state_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="city_name" name="city_name"
                                                placeholder="Enter City Name"
                                                value="{{ old('city_name', isset($city) ? $city->name : '') }}">
                                            @error('city_name')
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
                                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>
                                                    Deactive
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
    <script>
        $(document).ready(function() {
            var stateDropdown = $('#state_name');
            var oldStateID = "{{ old('state_name') }}"; // Getting old state ID from Laravel
            var oldCountryID = "{{ old('country_name') }}"; // Getting old country ID

            // Country Change Event
            $('#country_name').on('change', function() {
                var country_id = $(this).val();

                if (country_id) {
                    $.ajax({
                        url: "{{ route('fetch_states_by_country') }}",
                        method: 'GET',
                        data: {
                            country_id: country_id
                        },
                        success: function(response) {
                            stateDropdown.empty().append(
                                '<option value="">Select State</option>');

                            response.states.forEach(function(state) {
                                var selected = (state.location_id == oldStateID) ?
                                    'selected' : '';

                                stateDropdown.append('<option value="' + state
                                    .location_id + '" ' + selected + '>' + state
                                    .name + '</option>');
                            });

                            // Auto-select old state name when AJAX is done
                            if (oldStateID) {
                                stateDropdown.val(oldStateID).trigger('change');
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                } else {
                    stateDropdown.empty().append('<option value="">Select State</option>');
                }
            });

            // If old country exists, trigger change to load states
            if (oldCountryID) {
                $('#country_name').val(oldCountryID).trigger('change');
            }
        });
    </script>
@endsection
