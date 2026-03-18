@include('front.dashboard.header')
<div class="main dashboard">
    <section class="account-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="account-form">
                        <h3>Account Details</h3>
                        <form id="account-form" action="{{ route('account.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name *</label>
                                        <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $user->name ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name *</label>
                                        <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $user->lastname ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <input type="email" id="email" name="email" class="form-control" value="{{ $user->email ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone Number *</label>
                                        <input type="tel" id="phone" name="phone" class="form-control" value="{{ $user->phone ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select id="gender" name="gender" class="form-control">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" id="dob" name="dob" class="form-control" value="{{ $user->dob ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <h4 class="mt-4">Address Information</h4>
                            <div class="row">
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
                                                <option value="{{ $country->id }}" {{ $selectedCountry == $country->id ? 'selected' : '' }}>
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
                                            @if($selectedState)
                                                @php
                                                    $states = Location::where('location_type', 1)->where('country_id', $selectedCountry)->where('status', 0)->get();
                                                @endphp
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}" {{ $selectedState == $state->id ? 'selected' : '' }}>
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
                                            @if($selectedCity)
                                                @php
                                                    $cities = Location::where('location_type', 2)->where('state_id', $selectedState)->where('status', 0)->get();
                                                @endphp
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}" {{ $selectedCity == $city->id ? 'selected' : '' }}>
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
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                                <a href="{{ route('user.dashboard') }}" class="btn btn-outline">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="profile-summary">
                        <h3>Profile Summary</h3>
                        <div class="profile-info">
                            <div class="profile-avatar">
                                @if($user->image)
                                    <img src="{{ asset('user/' . $user->image) }}" alt="{{ $user->name }}">
                                @else
                                    <div class="avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <h4>{{ $user->name }} {{ $user->lastname ?? '' }}</h4>
                            <p>{{ $user->email }}</p>
                            <p>{{ $user->phone ?? '' }}</p>
                        </div>

                        <div class="quick-links">
                            <h5>Quick Links</h5>
                            <ul>
                                <li><a href="{{ route('user.order') }}">My Orders</a></li>
                                <li><a href="{{ route('cart.view') }}">Shopping Cart</a></li>
                                <li><a href="{{ route('user.address') }}">Manage Addresses</a></li>
                                <li><a href="{{ route('user.change_password') }}">Change Password</a></li>
                            </ul>
                        </div>

                        <div class="account-stats">
                            <h5>Account Statistics</h5>
                            <div class="stat-item">
                                <span class="stat-number">{{ $user->orders->count() ?? 0 }}</span>
                                <span class="stat-label">Total Orders</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">{{ $user->reviews->count() ?? 0 }}</span>
                                <span class="stat-label">Reviews Written</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">{{ $user->wishlist->count() ?? 0 }}</span>
                                <span class="stat-label">Wishlist Items</span>
                            </div>
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
});
</script>

@include('front.dashboard.footer')
