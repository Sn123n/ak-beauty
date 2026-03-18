@include('front.dashboard.header')
    <div class="main profile dashboard">
        <section class="">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="sec-title text-start">
                            <h3 class="section-main-title">
                                Profile
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <p>{{ $user->name ?? 'Name' }} <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#address"><i class="fa-solid fa-pen"></i></a></p>
                        <div class="mail-address">
                            <p>Email</p>
                            <h6>{{ $user->email ?? 'akbeauty@gmail.com' }}</h6>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="inner-pad">
                            <p class="profile-address-add">Addresses <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addaddress"><i class="fa-solid fa-plus"></i>Add</a></p>
                            @if($userAddresses && $userAddresses->count() > 0)
                                @foreach($userAddresses as $address)
                                    <div class="profile-address mb-3" data-address-id="{{ $address->id }}">
                                        <span>
                                            @if($loop->first) Default address @else Address {{ $loop->iteration }} @endif
                                            <a href="javascript:void(0);" class="edit-address" data-address-id="{{ $address->id }}" data-bs-toggle="modal" data-bs-target="#editaddress"><i class="fa-solid fa-pen"></i></a>
                                            <a href="javascript:void(0);" class="delete-address ms-2" data-address-id="{{ $address->id }}"><i class="fa-solid fa-trash"></i></a>
                                        </span>
                                        <p>{{ $address->name ?? 'N/A' }}</p>
                                        <p>{{ $address->address ?? 'N/A' }}</p>
                                        @php
                                            $countryName = $address->country ? \App\Models\Location::find($address->country)->name ?? '' : '';
                                            $stateName = $address->state ? \App\Models\Location::find($address->state)->name ?? '' : '';
                                            $cityName = $address->city ? \App\Models\Location::find($address->city)->name ?? '' : '';
                                        @endphp
                                        <p>{{ $address->pincode ?? '' }} {{ $cityName }} {{ $stateName }}</p>
                                        <p>{{ $countryName }}</p>
                                    </div>
                                @endforeach
                            @else
                                <div class="open-modal-profile" data-bs-toggle="modal" data-bs-target="#addaddress">
                                    <div class="profile-address">
                                        <p class="text-muted">No addresses added yet. Click to add your first address.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <form id="profile-form">
        <div class="modal address-modal fade" id="address" tabindex="-1" aria-labelledby="addressLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addressLabel">Edit profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="profile-errors" class="alert alert-danger d-none"></div>
                        <div id="profile-success" class="alert alert-success d-none"></div>
                        <div class="row">
                            @php
                                $nameParts = explode(' ', $user->name ?? '', 2);
                                $firstName = $nameParts[0] ?? '';
                                $lastName = $nameParts[1] ?? '';
                            @endphp
                            <div class="col-lg-6 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="profile_first_name" name="first_name" placeholder="First name" value="{{ $firstName }}" required>
                                    <label for="profile_first_name">First name</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="profile_last_name" name="last_name" placeholder="Last name" value="{{ $lastName }}">
                                    <label for="profile_last_name">Last name</label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="profile_email" name="email" placeholder="Email" value="{{ $user->email ?? '' }}" required>
                                    <label for="profile_email">Email </label>
                                </div>
                                <span>Email can be changed</span>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-floating mb-3">
                                    <textarea name="address" id="profile_address" class="form-control" placeholder="Address">{{ $user->address ?? '' }}</textarea>
                                    <label for="profile_address">Address</label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-floating mb-3">
                                    <select name="country" id="profile_country" class="form-select">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->location_id }}" {{ $user->country == $country->location_id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="profile_country">Country/region</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-floating mb-3">
                                    <select name="state" id="profile_state" class="form-select">
                                        <option value="">Select State</option>
                                    </select>
                                    <label for="profile_state">State</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-floating mb-3">
                                    <select name="city" id="profile_city" class="form-select">
                                        <option value="">Select City</option>
                                    </select>
                                    <label for="profile_city">City</label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="profile_pincode" name="pincode" placeholder="Pincode" value="{{ $user->pincode ?? '' }}">
                                    <label for="profile_pincode">Pincode</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn ak-btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn ak-btn">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form id="add-address-form">
        <div class="modal address-modal fade" id="addaddress" tabindex="-1" aria-labelledby="addaddressLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addaddressLabel">Add address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="add-address-errors" class="alert alert-danger d-none"></div>
                        <div id="add-address-success" class="alert alert-success d-none"></div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="1" id="is_default" name="is_default">
                                    <label class="form-check-label" for="is_default">
                                         This is my default address
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-floating mb-3">
                                    <select name="country" id="add_country" class="form-select" required>
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->location_id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="add_country">Country/region</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="add_first_name" name="first_name" placeholder="First name" required>
                                    <label for="add_first_name">First name</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="add_last_name" name="last_name" placeholder="Last name">
                                    <label for="add_last_name">Last name</label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-floating mb-3">
                                    <textarea name="address" id="add_address" class="form-control" required></textarea>
                                    <label for="add_address">Address</label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-floating mb-3">
                                    <textarea name="apartment" id="add_apartment" class="form-control"></textarea>
                                    <label for="add_apartment">Apartment, suite, etc (optional)</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-floating mb-3">
                                    <select name="state" id="add_state" class="form-select" required>
                                        <option value="">Select State</option>
                                    </select>
                                    <label for="add_state">State</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-floating mb-3">
                                    <select name="city" id="add_city" class="form-select" required>
                                        <option value="">Select City</option>
                                    </select>
                                    <label for="add_city">City</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="add_pincode" name="pincode" placeholder="Pincode">
                                    <label for="add_pincode">Pincode</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn ak-btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn ak-btn">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Edit Address Modal -->
    <form id="edit-address-form">
        <div class="modal address-modal fade" id="editaddress" tabindex="-1" aria-labelledby="editaddressLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editaddressLabel">Edit address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="edit-address-errors" class="alert alert-danger d-none"></div>
                        <div id="edit-address-success" class="alert alert-success d-none"></div>
                        <input type="hidden" id="edit_address_id" name="address_id">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="1" id="edit_is_default" name="is_default">
                                    <label class="form-check-label" for="edit_is_default">
                                         This is my default address
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-floating mb-3">
                                    <select name="country" id="edit_country" class="form-select" required>
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->location_id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="edit_country">Country/region</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="edit_first_name" name="first_name" placeholder="First name" required>
                                    <label for="edit_first_name">First name</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="edit_last_name" name="last_name" placeholder="Last name">
                                    <label for="edit_last_name">Last name</label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-floating mb-3">
                                    <textarea name="address" id="edit_address" class="form-control" required></textarea>
                                    <label for="edit_address">Address</label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-floating mb-3">
                                    <textarea name="apartment" id="edit_apartment" class="form-control"></textarea>
                                    <label for="edit_apartment">Apartment, suite, etc (optional)</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-floating mb-3">
                                    <select name="state" id="edit_state" class="form-select" required>
                                        <option value="">Select State</option>
                                    </select>
                                    <label for="edit_state">State</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-floating mb-3">
                                    <select name="city" id="edit_city" class="form-select" required>
                                        <option value="">Select City</option>
                                    </select>
                                    <label for="edit_city">City</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="edit_pincode" name="pincode" placeholder="Pincode">
                                    <label for="edit_pincode">Pincode</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn ak-btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn ak-btn">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        // Wait for jQuery to be loaded
        (function() {
            function initProfileScripts() {
                if (typeof jQuery === 'undefined') {
                    setTimeout(initProfileScripts, 100);
                    return;
                }
                
                jQuery(document).ready(function($) {
                    // Load states and cities when profile modal opens
                    $('#address').on('shown.bs.modal', function() {
                var countryId = $('#profile_country').val();
                var stateId = {{ $user->state ?? 'null' }};
                var cityId = {{ $user->city ?? 'null' }};
                
                console.log('Modal opened - Country:', countryId, 'State:', stateId, 'City:', cityId);
                
                if (countryId) {
                    loadProfileStates(countryId, stateId, cityId);
                }
            });

            // Profile Update Form
            $('#profile-form').on('submit', function(e) {
                e.preventDefault();
                $('#profile-errors').addClass('d-none').html('');
                $('#profile-success').addClass('d-none').html('');

                var submitBtn = $(this).find('button[type="submit"]');
                var originalText = submitBtn.text();
                submitBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: '{{ route("user.profile.update") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('Profile update response:', response);
                        submitBtn.prop('disabled', false).text(originalText);
                        if (response.status === 'success') {
                            // Use showToast if available, otherwise fallback to alert
                            if (typeof showToast === 'function') {
                                showToast(response.message || 'Profile updated successfully!', 'success');
                            } else {
                                alert(response.message || 'Profile updated successfully!');
                            }
                            $('#address').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            if (typeof showToast === 'function') {
                                showToast(response.message || 'Something went wrong!', 'error');
                            } else {
                                alert(response.message || 'Something went wrong!');
                            }
                        }
                    },
                    error: function(xhr) {
                        console.log('Profile update error:', xhr);
                        submitBtn.prop('disabled', false).text(originalText);
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessages = [];
                            $.each(errors, function(key, value) {
                                errorMessages.push(value[0]);
                            });
                            var errorMsg = errorMessages.join(', ');
                            if (typeof showToast === 'function') {
                                showToast(errorMsg, 'error');
                            } else {
                                alert(errorMsg);
                            }
                            var errorHtml = '<ul>';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] + '</li>';
                            });
                            errorHtml += '</ul>';
                            $('#profile-errors').removeClass('d-none').html(errorHtml);
                        } else {
                            var errorMsg = xhr.responseJSON?.message || 'Something went wrong. Please try again.';
                            if (typeof showToast === 'function') {
                                showToast(errorMsg, 'error');
                            } else {
                                alert(errorMsg);
                            }
                            $('#profile-errors').removeClass('d-none').html('<p>' + errorMsg + '</p>');
                        }
                    }
                });
            });

            // Fetch States by Country (Profile Form)
            $(document).on('change', '#profile_country', function() {
                var countryId = $(this).val();
                console.log('Country changed:', countryId);
                $('#profile_state').html('<option value="">Select State</option>');
                $('#profile_city').html('<option value="">Select City</option>');
                
                if (countryId) {
                    loadProfileStates(countryId);
                } else {
                    $('#profile_state').html('<option value="">Select State</option>');
                    $('#profile_city').html('<option value="">Select City</option>');
                }
            });

            // Fetch Cities by State (Profile Form)
            $(document).on('change', '#profile_state', function() {
                var stateId = $(this).val();
                console.log('State changed:', stateId);
                $('#profile_city').html('<option value="">Select City</option>');
                
                if (stateId) {
                    loadProfileCities(stateId);
                } else {
                    $('#profile_city').html('<option value="">Select City</option>');
                }
            });

            // Function to load states and cities for profile form
            function loadProfileStates(countryId, selectedStateId, selectedCityId) {
                if (!countryId) {
                    countryId = $('#profile_country').val();
                }
                
                if (!countryId) {
                    console.log('No country ID provided');
                    return;
                }
                
                console.log('Loading states for country:', countryId);
                
                $.ajax({
                    url: '{{ route("user.fetch_states_by_country") }}',
                    method: 'GET',
                    data: { country_id: countryId },
                    success: function(response) {
                        console.log('States response:', response);
                        $('#profile_state').html('<option value="">Select State</option>');
                        if (response.states && response.states.length > 0) {
                            response.states.forEach(function(state) {
                                var selected = (selectedStateId && parseInt(state.location_id) === parseInt(selectedStateId)) ? ' selected' : '';
                                $('#profile_state').append('<option value="' + state.location_id + '"' + selected + '>' + state.name + '</option>');
                            });
                            
                            // Load cities if state is selected
                            if (selectedStateId) {
                                loadProfileCities(selectedStateId, selectedCityId);
                            }
                        } else {
                            console.log('No states found for country:', countryId);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading states:', error);
                        console.error('Response:', xhr.responseText);
                    }
                });
            }
            
            // Function to load cities for profile form
            function loadProfileCities(stateId, selectedCityId) {
                if (!stateId) {
                    console.log('No state ID provided');
                    return;
                }
                
                console.log('Loading cities for state:', stateId);
                
                $.ajax({
                    url: '{{ route("user.fetch_cities_by_state") }}',
                    method: 'GET',
                    data: { state_id: stateId },
                    success: function(response) {
                        console.log('Cities response:', response);
                        $('#profile_city').html('<option value="">Select City</option>');
                        if (response.cities && response.cities.length > 0) {
                            response.cities.forEach(function(city) {
                                var selected = (selectedCityId && parseInt(city.location_id) === parseInt(selectedCityId)) ? ' selected' : '';
                                $('#profile_city').append('<option value="' + city.location_id + '"' + selected + '>' + city.name + '</option>');
                            });
                        } else {
                            console.log('No cities found for state:', stateId);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading cities:', error);
                        console.error('Response:', xhr.responseText);
                    }
                });
            }

            // Fetch States by Country (Add Address)
            $('#add_country').on('change', function() {
                var countryId = $(this).val();
                $('#add_state').html('<option value="">Select State</option>');
                $('#add_city').html('<option value="">Select City</option>');
                
                if (countryId) {
                    $.ajax({
                        url: '{{ route("user.fetch_states_by_country") }}',
                        method: 'GET',
                        data: { country_id: countryId },
                        success: function(response) {
                            response.states.forEach(function(state) {
                                $('#add_state').append('<option value="' + state.location_id + '">' + state.name + '</option>');
                            });
                        }
                    });
                }
            });

            // Fetch Cities by State (Add Address)
            $('#add_state').on('change', function() {
                var stateId = $(this).val();
                $('#add_city').html('<option value="">Select City</option>');
                
                if (stateId) {
                    $.ajax({
                        url: '{{ route("user.fetch_cities_by_state") }}',
                        method: 'GET',
                        data: { state_id: stateId },
                        success: function(response) {
                            response.cities.forEach(function(city) {
                                $('#add_city').append('<option value="' + city.location_id + '">' + city.name + '</option>');
                            });
                        }
                    });
                }
            });

            // Add Address Form
            $('#add-address-form').on('submit', function(e) {
                e.preventDefault();
                $('#add-address-errors').addClass('d-none').html('');
                $('#add-address-success').addClass('d-none').html('');

                $.ajax({
                    url: '{{ route("user.address.store") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#add-address-success').removeClass('d-none').html('<p>' + response.message + '</p>');
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorHtml = '<ul>';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] + '</li>';
                            });
                            errorHtml += '</ul>';
                            $('#add-address-errors').removeClass('d-none').html(errorHtml);
                        } else {
                            $('#add-address-errors').removeClass('d-none').html('<p>Something went wrong. Please try again.</p>');
                        }
                    }
                });
            });

            // Edit Address - Load Data
            $(document).on('click', '.edit-address', function() {
                var addressId = $(this).data('address-id');
                
                $.ajax({
                    url: '{{ route("user.address.get", ":id") }}'.replace(':id', addressId),
                    method: 'GET',
                    success: function(response) {
                        if (response.status === 'success') {
                            var addr = response.address;
                            $('#edit_address_id').val(addr.id);
                            $('#edit_first_name').val(addr.first_name);
                            $('#edit_last_name').val(addr.last_name);
                            $('#edit_address').val(addr.address);
                            $('#edit_apartment').val(addr.apartment);
                            $('#edit_pincode').val(addr.pincode);
                            $('#edit_country').val(addr.country);
                            
                            // Load states
                            if (addr.country) {
                                $.ajax({
                                    url: '{{ route("user.fetch_states_by_country") }}',
                                    method: 'GET',
                                    data: { country_id: addr.country },
                                    success: function(stateResponse) {
                                        $('#edit_state').html('<option value="">Select State</option>');
                                        stateResponse.states.forEach(function(state) {
                                            $('#edit_state').append('<option value="' + state.location_id + '"' + (state.location_id == addr.state ? ' selected' : '') + '>' + state.name + '</option>');
                                        });
                                        
                                        // Load cities
                                        if (addr.state) {
                                            $.ajax({
                                                url: '{{ route("user.fetch_cities_by_state") }}',
                                                method: 'GET',
                                                data: { state_id: addr.state },
                                                success: function(cityResponse) {
                                                    $('#edit_city').html('<option value="">Select City</option>');
                                                    cityResponse.cities.forEach(function(city) {
                                                        $('#edit_city').append('<option value="' + city.location_id + '"' + (city.location_id == addr.city ? ' selected' : '') + '>' + city.name + '</option>');
                                                    });
                                                }
                                            });
                                        }
                                    }
                                });
                            }
                        }
                    },
                    error: function() {
                        alert('Error loading address data.');
                    }
                });
            });

            // Fetch States by Country (Edit Address)
            $('#edit_country').on('change', function() {
                var countryId = $(this).val();
                $('#edit_state').html('<option value="">Select State</option>');
                $('#edit_city').html('<option value="">Select City</option>');
                
                if (countryId) {
                    $.ajax({
                        url: '{{ route("user.fetch_states_by_country") }}',
                        method: 'GET',
                        data: { country_id: countryId },
                        success: function(response) {
                            response.states.forEach(function(state) {
                                $('#edit_state').append('<option value="' + state.location_id + '">' + state.name + '</option>');
                            });
                        }
                    });
                }
            });

            // Fetch Cities by State (Edit Address)
            $('#edit_state').on('change', function() {
                var stateId = $(this).val();
                $('#edit_city').html('<option value="">Select City</option>');
                
                if (stateId) {
                    $.ajax({
                        url: '{{ route("user.fetch_cities_by_state") }}',
                        method: 'GET',
                        data: { state_id: stateId },
                        success: function(response) {
                            response.cities.forEach(function(city) {
                                $('#edit_city').append('<option value="' + city.location_id + '">' + city.name + '</option>');
                            });
                        }
                    });
                }
            });

            // Edit Address Form
            $('#edit-address-form').on('submit', function(e) {
                e.preventDefault();
                var addressId = $('#edit_address_id').val();
                $('#edit-address-errors').addClass('d-none').html('');
                $('#edit-address-success').addClass('d-none').html('');

                $.ajax({
                    url: '{{ route("user.address.update.id", ":id") }}'.replace(':id', addressId),
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#edit-address-success').removeClass('d-none').html('<p>' + response.message + '</p>');
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorHtml = '<ul>';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] + '</li>';
                            });
                            errorHtml += '</ul>';
                            $('#edit-address-errors').removeClass('d-none').html(errorHtml);
                        } else {
                            $('#edit-address-errors').removeClass('d-none').html('<p>Something went wrong. Please try again.</p>');
                        }
                    }
                });
            });

            // Delete Address
            $(document).on('click', '.delete-address', function() {
                if (!confirm('Are you sure you want to delete this address?')) {
                    return;
                }
                
                var addressId = $(this).data('address-id');
                $.ajax({
                    url: '{{ route("user.address.delete", ":id") }}'.replace(':id', addressId),
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        alert('Error deleting address. Please try again.');
                    }
                });
            });

            // Reset Add Address Form when modal closes
            $('#addaddress').on('hidden.bs.modal', function() {
                $('#add-address-form')[0].reset();
                $('#add_state').html('<option value="">Select State</option>');
                $('#add_city').html('<option value="">Select City</option>');
                $('#add-address-errors').addClass('d-none').html('');
                $('#add-address-success').addClass('d-none').html('');
            });
                }); // End of jQuery(document).ready
            } // End of initProfileScripts
            
            // Start initialization
            initProfileScripts();
        })(); // End of IIFE
    </script>
@include('front.dashboard.footer')
