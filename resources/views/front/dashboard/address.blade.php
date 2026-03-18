@include('front.dashboard.header')
<div class="main dashboard">
    <section class="address-management">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="address-form">
                        <h3>{{ $userAddress ? 'Edit Address' : 'Add New Address' }}</h3>
                        <form id="address-form" action="{{ $userAddress ? route('user.address.update.id', $userAddress->id) : route('user.address.store') }}" method="POST">
                            @csrf
                            @if($userAddress) @method('PUT') @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address_type">Address Type</label>
                                        <select id="address_type" name="address_type" class="form-control">
                                            <option value="home" {{ $userAddress->address_type == 'home' ? 'selected' : '' }}>Home</option>
                                            <option value="work" {{ $userAddress->address_type == 'work' ? 'selected' : '' }}>Work</option>
                                            <option value="other" {{ $userAddress->address_type == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Street Address *</label>
                                        <input type="text" id="address" name="address" class="form-control" value="{{ $userAddress->address ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address2">Apartment, floor, etc. (optional)</label>
                                        <input type="text" id="address2" name="address2" class="form-control" value="{{ $userAddress->address2 ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="country">Country *</label>
                                        <select id="country" name="country" class="form-control" required>
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ $selectedShippingCountry == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state">State *</label>
                                        <select id="state" name="state" class="form-control" required>
                                            <option value="">Select State</option>
                                            @if($userAddress->state)
                                                @php
                                                    $states = Location::where('location_type', 1)->where('country_id', $selectedShippingCountry)->where('status', 0)->get();
                                                @endphp
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}" {{ $userAddress->state == $state->id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city">City *</label>
                                        <select id="city" name="city" class="form-control" required>
                                            <option value="">Select City</option>
                                            @if($userAddress->city)
                                                @php
                                                    $cities = Location::where('location_type', 2)->where('state_id', $userAddress->state)->where('status', 0)->get();
                                                @endphp
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}" {{ $userAddress->city == $city->id ? 'selected' : '' }}>
                                                        {{ $city->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pincode">PIN Code *</label>
                                        <input type="text" id="pincode" name="pincode" class="form-control" value="{{ $userAddress->pincode ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone Number *</label>
                                        <input type="tel" id="phone" name="phone" class="form-control" value="{{ $userAddress->phone ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="default_address" name="default_address" value="1" {{ $userAddress->is_default ? 'checked' : '' }}>
                                        <label class="form-check-label" for="default_address">
                                            Set as default address
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    {{ $userAddress ? 'Update Address' : 'Add Address' }}
                                </button>
                                <a href="{{ route('user.dashboard') }}" class="btn btn-outline">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="saved-addresses">
                        <h3>Saved Addresses</h3>
                        <div class="address-list">
                            @php
                                $allAddresses = \App\Models\UserAddress::where('user_id', auth()->id())->get();
                            @endphp
                            @forelse($allAddresses as $address)
                                <div class="address-card {{ $address->is_default ? 'default' : '' }}">
                                    <div class="address-header">
                                        <h5>{{ ucfirst($address->address_type) }} Address</h5>
                                        @if($address->is_default)
                                            <span class="badge bg-primary">Default</span>
                                        @endif
                                    </div>
                                    <div class="address-details">
                                        <p>
                                            {{ $address->address }}<br>
                                            @if($address->address2) {{ $address->address2 }}<br>@endif
                                            {{ $address->city_name ?? '' }}, {{ $address->state_name ?? '' }}<br>
                                            {{ $address->country_name ?? '' }} - {{ $address->pincode }}<br>
                                            Phone: {{ $address->phone }}
                                        </p>
                                    </div>
                                    <div class="address-actions">
                                        <a href="{{ route('user.address') }}?edit={{ $address->id }}" class="btn btn-sm btn-outline">Edit</a>
                                        <form action="{{ route('user.address.delete', $address->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this address?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="no-addresses">
                                    <i class="fas fa-map-marker-alt fa-2x text-muted mb-2"></i>
                                    <p>No saved addresses yet</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    // Load states when country changes
    $('#country').change(function() {
        var countryId = $(this).val();
        if (countryId) {
            $.get('{{ route("user.fetch_states_by_country") }}/' + countryId, function(data) {
                var stateSelect = $('#state');
                stateSelect.empty().append('<option value="">Select State</option>');
                $.each(data, function(key, value) {
                    stateSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $('#city').empty().append('<option value="">Select City</option>');
            });
        } else {
            $('#state').empty().append('<option value="">Select State</option>');
            $('#city').empty().append('<option value="">Select City</option>');
        }
    });

    // Load cities when state changes
    $('#state').change(function() {
        var stateId = $(this).val();
        if (stateId) {
            $.get('{{ route("user.fetch_cities_by_state") }}/' + stateId, function(data) {
                var citySelect = $('#city');
                citySelect.empty().append('<option value="">Select City</option>');
                $.each(data, function(key, value) {
                    citySelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            });
        } else {
            $('#city').empty().append('<option value="">Select City</option>');
        }
    });

    // Check for edit parameter
    const urlParams = new URLSearchParams(window.location.search);
    const editId = urlParams.get('edit');
    if (editId) {
        // Load the address data for editing
        $.get('/user/address/' + editId + '/edit', function(data) {
            // Populate form fields with address data
            $('#address_type').val(data.address_type);
            $('#address').val(data.address);
            $('#address2').val(data.address2);
            $('#country').val(data.country);
            $('#state').val(data.state);
            $('#city').val(data.city);
            $('#pincode').val(data.pincode);
            $('#phone').val(data.phone);
            $('#default_address').prop('checked', data.is_default);
        });
    }
});
</script>

@include('front.dashboard.footer')
