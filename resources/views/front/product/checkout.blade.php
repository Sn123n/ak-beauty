@include('front.layouts.header')
<div class="main">
    <section class="checkout-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-form">
                        <h3 class="section-title">Billing Details</h3>
                        <form id="checkout-form" action="{{ route('place.order') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- User Info -->
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

                                <!-- Address -->
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

                            <!-- Order Notes -->
                            <div class="form-group">
                                <label for="order_notes">Order Notes (optional)</label>
                                <textarea id="order_notes" name="order_notes" class="form-control" rows="3" placeholder="Special instructions for your order..."></textarea>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="order-summary">
                        <h3 class="section-title">Order Summary</h3>
                        
                        <!-- Cart Items -->
                        <div class="cart-items">
                            @php
                                $subtotal = 0;
                                $totalItems = 0;
                            @endphp
                            @foreach($cart as $productId => $item)
                                @php
                                    $itemTotal = ($item['discounted_price'] ?? $item['price']) * ($item['qnty'] ?? 1);
                                    $subtotal += $itemTotal;
                                    $totalItems += ($item['qnty'] ?? 1);
                                @endphp
                                <div class="cart-item">
                                    <div class="item-info">
                                        <h6>{{ $item['title'] }}</h6>
                                        <p>Qty: {{ $item['qnty'] ?? 1 }} × Rs. {{ number_format($item['discounted_price'] ?? $item['price'], 2) }}</p>
                                    </div>
                                    <div class="item-total">
                                        <strong>Rs. {{ number_format($itemTotal, 2) }}</strong>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Coupon -->
                        <div class="coupon-section">
                            <div class="form-group">
                                <input type="text" id="coupon_code" name="coupon_code" class="form-control" placeholder="Enter coupon code" value="{{ $coupon['code'] ?? '' }}">
                                <button type="button" id="apply_coupon" class="btn btn-outline">Apply</button>
                            </div>
                            @if($coupon)
                                <div class="coupon-applied">
                                    <span class="badge bg-success">Coupon Applied: {{ $coupon['code'] }}</span>
                                    <button type="button" id="remove_coupon" class="btn btn-sm btn-link">Remove</button>
                                </div>
                            @endif
                        </div>

                        <!-- Totals -->
                        <div class="order-totals">
                            <div class="total-row">
                                <span>Subtotal ({{ $totalItems }} items)</span>
                                <span>Rs. {{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="total-row">
                                <span>Shipping</span>
                                <span id="shipping-charge">Rs. 0.00</span>
                            </div>
                            @if($coupon)
                                <div class="total-row discount">
                                    <span>Discount ({{ $coupon['code'] }})</span>
                                    <span>-Rs. {{ number_format($coupon['discount_amount'], 2) }}</span>
                                </div>
                            @endif
                            <div class="total-row grand-total">
                                <span><strong>Total</strong></span>
                                <span><strong id="grand-total">Rs. {{ number_format($subtotal - ($coupon['discount_amount'] ?? 0), 2) }}</strong></span>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="payment-method">
                            <h4>Payment Method</h4>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label class="form-check-label" for="cod">
                                    Cash on Delivery (COD)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="online" value="online" disabled>
                                <label class="form-check-label" for="online">
                                    Online Payment (Coming Soon)
                                </label>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" form="checkout-form" class="btn btn-primary btn-lg w-100">
                            Place Order
                        </button>

                        <div class="security-note">
                            <p><i class="fas fa-lock"></i> Your payment information is secure and encrypted</p>
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

    // Check pincode availability
    $('#pincode').blur(function() {
        var pincode = $(this).val();
        if (pincode.length === 6) {
            $.get('{{ route("check.pincode") }}', {pincode: pincode}, function(data) {
                if (data.available) {
                    $('#shipping-charge').text('Rs. ' + data.shipping_charge);
                    updateGrandTotal();
                } else {
                    alert('Delivery not available for this pincode');
                    $('#shipping-charge').text('Rs. 0.00');
                    updateGrandTotal();
                }
            });
        }
    });

    // Apply coupon
    $('#apply_coupon').click(function() {
        var couponCode = $('#coupon_code').val();
        if (couponCode) {
            $.post('{{ route("validate.coupon") }}', {coupon_code: couponCode}, function(data) {
                if (data.valid) {
                    location.reload();
                } else {
                    alert(data.message || 'Invalid coupon code');
                }
            });
        }
    });

    // Remove coupon
    $('#remove_coupon').click(function() {
        $.post('{{ route("apply.coupon") }}', {remove: true}, function() {
            location.reload();
        });
    });

    function updateGrandTotal() {
        var subtotal = parseFloat($('meta[name="subtotal"]').attr('content') || 0);
        var shipping = parseFloat($('#shipping-charge').text().replace('Rs. ', '').replace(',', ''));
        var discount = parseFloat($('meta[name="discount"]').attr('content') || 0);
        var grandTotal = subtotal + shipping - discount;
        $('#grand-total').text('Rs. ' + grandTotal.toFixed(2));
    }
});
</script>

<!-- Hidden meta tags for JavaScript -->
<meta name="subtotal" content="{{ $subtotal }}">
<meta name="discount" content="{{ $coupon['discount_amount'] ?? 0 }}">

@include('front.layouts.footer')
