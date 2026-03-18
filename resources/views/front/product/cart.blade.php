@include('front.layouts.header')
<div class="main">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-6">
                    <div class="sec-title text-start">
                        <h3 class="section-main-title animate-on-scroll slide-up delay-5">
                            Your Cart
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6 col-6">
                    <div class="float-end link-header-title">
                        <a href="{{ route('product.list') }}">Continue shopping</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table cart-table" style="width:100%;">
                    <thead>
                        <tr>
                            <th colspan="2">PRODUCT</th>
                            <th class="d-lg-block d-none">QUANTITY</th>
                            <th class="text-end">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items">
                        @php
                            $subtotal = $subtotal ?? 0;
                            $cartItems = $cart ?? [];
                        @endphp
                        @forelse($cartItems as $productId => $item)
                            @php
                                $itemTotal = ($item['discounted_price'] ?? $item['price']) * ($item['qnty'] ?? 1);
                            @endphp
                            <tr data-product-id="{{ $productId }}">
                                <td class="cart-product">
                                    <div>
                                        <img src="{{ asset('product/' . $item['image']) }}" alt="{{ $item['title'] }}">
                                    </div>
                                </td>
                                <td class="cart-product-details">
                                    <div>
                                        <a href="{{ route('product.detail', $productId) }}">{{ $item['title'] }}</a>
                                        <p>Rs. {{ number_format($item['price'], 2) }}</p>
                                    </div>
                                    <div class="qty-count d-lg-none">
                                        <div class="quantity">
                                            <button class="qty-btn minus" data-product-id="{{ $productId }}" type="button">-</button>
                                            <input type="text" class="qty-input" value="{{ $item['qnty'] ?? 1 }}" readonly data-product-id="{{ $productId }}">
                                            <button class="qty-btn plus" data-product-id="{{ $productId }}" type="button">+</button>
                                        </div>
                                        <div>
                                            <button class="btn ak-btn delete-btn" data-product-id="{{ $productId }}"><i class="far fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-lg-block">
                                    <div class="qty-count">
                                        <div class="quantity">
                                            <button class="qty-btn minus" data-product-id="{{ $productId }}" type="button">-</button>
                                            <input type="text" class="qty-input" value="{{ $item['qnty'] ?? 1 }}" readonly data-product-id="{{ $productId }}">
                                            <button class="qty-btn plus" data-product-id="{{ $productId }}" type="button">+</button>
                                        </div>
                                        <div>
                                            <button class="btn ak-btn delete-btn" data-product-id="{{ $productId }}"><i class="far fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-end text-nowrap item-total">Rs. {{ number_format($itemTotal, 2) }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <p class="mb-0">Your cart is empty.</p>
                                    <a href="{{ route('product.list') }}" class="btn ak-btn mt-3">Continue Shopping</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="cart-total">
                <div class="row justify-content-end">
                    <div class="col-lg-4 col-md-7">
                        <div class="float-md-end">
                            <div>
                                <button class=" btn ak-btn checkout-btn w-100" id="checkout-btn" data-bs-target="#exampleModalToggle">
                                    <div>
                                        CHECKOUT <br>
                                        <span>5% off on prepaid orders</span>
                                    </div>
                                    <div>
                                        <img src="assets/images/paytm.png" alt="">
                                    </div>
                                    <div>
                                        <img src="assets/images/phonepe.png" alt="">
                                    </div>
                                    <div>
                                        <img src="assets/images/google.png" alt="">
                                    </div>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="float-md-end text-center text-md-end">
                            <div>
                                <div class="estimate-total">
                                    <p>Estimated Total</p>
                                    <p id="cart-subtotal">Rs. {{ number_format($subtotal ?? 0, 2) }}</p>
                                </div>
                            </div>
                            <div class="tax">
                                <p>Tax included. <a href="javasctipt:void(0);">Shipping</a> and discounts calculated at checkout.</p>
                            </div>
                            <div class="checkout-rating">
                                <div class="row align-items-center justify-content-center">
                                    <div class="col-lg-6 col-md-6">
                                        <div>
                                            <ul>
                                                <li><i class="fas fa-check-circle"></i></li>
                                                <li><span>5.0</span></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="border-lr">
                                            <p>5.0 out of 5 stars based on 268 reviews</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="verify">
                                            verified <span><img src="assets/images/verified-checkmark.svg" alt=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<form action="">
    <div class="modal fade checkout-modal" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex gap-1 align-items-center">
                        <a href="javascript:void(0);" data-bs-dismiss="modal"><i class="fa-solid fa-chevron-left"></i></a>
                        <div class="modal-logo">
                            <img src="assets/images/logo-3.png" alt="image not found">
                        </div>
                    </div>
                    <div class="float-end">
                        <p>100% Secured Payment <i class="fa-solid fa-lock"></i></p>
                    </div>
                </div>
                <div class="modal-body d-none">
                    <div class="discount-line">
                        Extra Discount Available at Payment Step
                    </div>
                    <div class="order-summary">
                        <div class="os-header">
                            <div>
                                <button type="button" class="btn ak-btn os-btn"><i class="fa-solid fa-cart-shopping"></i> Order Summary</button>
                            </div>
                            <div class="os-header-price">
                                @if(isset($mrpTotal) && $mrpTotal > ($subtotal ?? 0))
                                    <del> ₹{{ number_format($mrpTotal, 2) }}</del>
                                @endif
                                <span>₹{{ number_format($subtotal ?? 0, 2) }}</span>
                            </div>
                        </div>
                        <div class="os-body">
                            @if(!empty($cart))
                                @foreach($cart as $productId => $item)
                                    @php
                                        $itemPrice = $item['price'] ?? 0;
                                        $itemDiscountedPrice = $item['discounted_price'] ?? $itemPrice;
                                        $itemQty = $item['qnty'] ?? 1;
                                    @endphp
                                    <div class="os-product-detail">
                                        <div class="os-product">
                                            <img src="{{ asset('product/' . ($item['image'] ?? '')) }}" alt="{{ $item['title'] ?? '' }}">
                                        </div>
                                        <div>
                                            <div class="os-product-name">
                                                {{ $item['title'] ?? 'Product' }}
                                            </div>
                                            <div class="os-price">Price: <span> 
                                                @if($itemPrice > $itemDiscountedPrice)
                                                    <del> ₹{{ number_format($itemPrice, 2) }}</del>
                                                @endif
                                                ₹{{ number_format($itemDiscountedPrice, 2) }}
                                            </span></div>
                                            <div class="os-qty">Quantity: {{ $itemQty }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="price-summary">
                                <ul>
                                    <li>
                                        <span>MRP Total</span> ₹{{ number_format($mrpTotal ?? 0, 2) }}
                                    </li>
                                    @if(($totalDiscount ?? 0) > 0)
                                        <li>
                                            <span>Discount on MRP</span> ₹{{ number_format($totalDiscount ?? 0, 2) }}
                                        </li>
                                    @endif
                                    <li>
                                        <span>Subtotal</span> ₹{{ number_format($subtotal ?? 0, 2) }}
                                    </li>
                                    <li>
                                        <span>Shipping</span> To be calculated
                                    </li>
                                    <li>
                                        <span>To Pay</span> ₹{{ number_format($subtotal ?? 0, 2) }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="coupon-add">
                        <div>
                            <span class="input-group-text" id=""><i class="fa-solid fa-percent"></i></span>
                        </div>
                        <div class="form-floating ">
                            <input type="search" class="form-control" id="coupon" placeholder="ENTER COUPON CODE">
                            <label for="coupon">Email address</label>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-2 label"><i class="fa-regular fa-circle-user"></i> Login to continue</div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">+91 |</span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="mobile_number" placeholder="Mobile Number">
                                    <label for="mobile_number">Enter Mobile Number</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body d-none">
                    <div class="card">
                        <div class="card-header">
                            <a href="javascript:void(0);"><i class="fa-solid fa-chevron-left"></i> Edit Address</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="pin" placeholder="">
                                        <label for="pin">Pincode *</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="city" readonly class=" form-control" id="city" placeholder="Rajkot">
                                        <label for="city">City *</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" readonly class=" form-control" id="state" placeholder="Gujarat">
                                        <label for="state">State *</label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="">
                                        <label for="floatingInput">Flat, House no. *</label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="area" aria-label="">
                                            <option>mavdi main road</option>
                                        </select>
                                        <label for="ares">Apartment, Area, Sector, Village *</label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <h6 class="mb-2">Customer Information</h6>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="name" placeholder="Name">
                                        <label for="name">Name</label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="email" placeholder="">
                                        <label for="email">Email Address *</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <button type="button" class="btn ak-outline-btn">
                                        Home
                                        <input class="form-check-input ms-2" type="radio" name="place" id="home" value="option1" checked>
                                    </button>
                                </div>
                                <div class="col-lg-4">
                                    <button type="button" class="btn ak-outline-btn">
                                        Work
                                        <input class="form-check-input ms-2" type="radio" name="place" id="work" value="option2">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body ">
                    <div class="delivery-box">
                        <h6>Delivery Details</h6>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="customer-address-details">
                                        <div><i class="fa-solid fa-location-dot"></i></div>
                                        <div>
                                            @if($userAddress ?? null)
                                                <h6>Deliver TO {{ $userAddress->name ?? ($user->name ?? 'Customer Name') }}</h6>
                                                <p>{{ $userAddress->address ?? 'Address not set' }}
                                                    @if($userAddress->city)
                                                        <br>
                                                        @php
                                                            $cityName = $userAddress->city ? \App\Models\Location::find($userAddress->city)->name ?? '' : '';
                                                            $stateName = $userAddress->state ? \App\Models\Location::find($userAddress->state)->name ?? '' : '';
                                                        @endphp
                                                        {{ $cityName }}{{ $stateName ? ', ' . $stateName : '' }}
                                                    @endif
                                                    @if($userAddress->pincode)
                                                        , {{ $userAddress->pincode }}
                                                    @endif
                                                </p>
                                                <span>{{ $user->phone ?? '' }} | {{ $userAddress->email ?? ($user->email ?? '') }}</span>
                                            @elseif($user ?? null)
                                                <h6>Deliver TO {{ $user->name ?? 'Customer Name' }}</h6>
                                                <p>{{ $user->address ?? 'Address not set' }}
                                                    @if($user->city)
                                                        <br>
                                                        {{ $user->city ?? '' }}{{ $user->state ? ', ' . $user->state : '' }}{{ $user->pincode ? ', ' . $user->pincode : '' }}
                                                    @endif
                                                </p>
                                                <span>{{ $user->phone ?? '' }} | {{ $user->email ?? '' }}</span>
                                            @else
                                                <h6>Please add delivery address</h6>
                                                <p>No address found. Please add your delivery address.</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn ak-outline-btn" id="show-address-selector-btn">Change</button>
                                    </div>
                                </div>
                                <div class="parcle-type">
                                    <p>Standard</p>
                                    <small id="delivery-charge-display">₹{{ number_format($deliveryCharge ?? 100, 2) }}</small>
                                </div>
                            </div>
                        </div>
                        <h6>Offers & Rewards</h6>
                        <div class="coupon-add">
                            <div>
                                <span class="input-group-text" id=""><i class="fa-solid fa-percent"></i></span>
                            </div>
                            <div class="form-floating ">
                                <input type="search" class="form-control" id="coupon" placeholder="ENTER COUPON CODE">
                                <label for="coupon">Email address</label>
                            </div>
                        </div>
                        <h6>Payment Options</h6>
                        <div class="payment-offer">
                            <p>Additional 5% off on prepaid orders</p>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="upi-details">
                                    <div class="d-flex justify-content-between">
                                        <div class="upi-icon"><img src="assets/images/upi.png" alt=""> UPI</div>
                                        @php
                                            $prepaidSubtotal = ($subtotal ?? 0) * 0.95; // 5% discount on prepaid
                                            $prepaidTotal = $prepaidSubtotal + ($deliveryCharge ?? 100); // Add delivery charge
                                            $amountParts = explode('.', number_format($prepaidTotal, 2));
                                        @endphp
                                        <h5 id="prepaid-amount-display">₹{{ $amountParts[0] }}. <span class="decimal-price">{{ $amountParts[1] ?? '00' }}</span></h5>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-lg-7">
                                            <div class="all-payment">
                                                <p>Open any UPI Apps & scan QR Code to pay</p>
                                                <img src="assets/images/payment.png" alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="position-relative" style="min-height: 200px;">
                                                <img src="assets/images/or-code.svg" alt="" id="qr-code-image" class="blur" style="width: 100%; height: auto;">
                                                <a href="javascript:void(0);" class="qr-button" id="show-qr-code-btn" style="z-index: 10; padding: 8px 12px; display: inline-flex; align-items: center; gap: 5px;"><i class="fa-solid fa-eye"></i> Click to see QR code</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="or"> <span>OR</span></div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="upi_id" placeholder="Pay via UPI ID">
                                        <label for="uip_id">Pay via UPI ID</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row payment-selection">
                            <div class="col-lg-12">
                                <div class="mb-2">
                                    <button type="button" class="btn ak-btn d-flex justify-content-between w-100">
                                        <div><i class="fa-solid fa-credit-card"></i> Debit/Credit Cards</div>
                                        <div id="debit-card-amount">₹{{ number_format($prepaidTotal, 2) }} <i class="fa-solid fa-chevron-right"></i></div>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-2">
                                    <button type="button" class="btn ak-btn d-flex justify-content-between w-100">
                                        <div><i class="fa-solid fa-wallet"></i> Wallets</div>
                                        <div id="wallet-amount">₹{{ number_format($prepaidTotal, 2) }} <i class="fa-solid fa-chevron-right"></i></div>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-2">
                                    <button type="button" class="btn ak-btn d-flex justify-content-between w-100">
                                        <div><i class="fa-solid fa-building-columns"></i> Netbanking</div>
                                        <div id="netbanking-amount">₹{{ number_format($prepaidTotal, 2) }} <i class="fa-solid fa-chevron-right"></i></div>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-2">
                                    <button type="button" class="btn ak-btn d-flex justify-content-between w-100" id="cash-on-delivery-btn">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-credit-card"></i>
                                            <div class="text-start lh-4"> Cash on Delivery <br>
                                                <small class="mt-n1 d-block fs-12" id="cod-payment-info">₹{{ number_format($deliveryCharge ?? 100, 2) }} advance + ₹{{ number_format($subtotal ?? 0, 2) }} on delivery</small>
                                            </div>
                                        </div>
                                        <div id="cod-amount-display">₹{{ number_format($deliveryCharge ?? 100, 2) }} <i class="fa-solid fa-chevron-right"></i></div>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card logout">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    @if($user ?? null)
                                        <div class="d-flex align-items-center gap-1"><i class="fa-regular fa-circle-user"></i> Logged in using <strong>{{ $user->phone ? '+91 ' . $user->phone : $user->email }}</strong></div>
                                        <div class=""><a href="{{ route('user.logout') }}">Logout</a></div>
                                    @else
                                        <div class="d-flex align-items-center gap-1"><i class="fa-regular fa-circle-user"></i> <a href="{{ route('user.login') }}">Login to continue</a></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body d-none">
                    <div class="debit-card">
                        <div class="debit-title mb-3"><i class="fa-regular fa-credit-card"></i> Credit/Debit Card</div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <div class="form-floating ">
                                        <input type="text" class="form-control" id="name" value="ak beauty" placeholder="Name">
                                        <label for="name">Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <div class="form-floating ">
                                        <input type="text" class="form-control" id="card_number" placeholder="Card Number">
                                        <label for="card_number">Card Number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <div class="form-floating ">
                                        <input type="text" class="form-control" id="ex_date" placeholder="Expiry Date">
                                        <label for="ex_date">Expiry Date</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="form-floating">
                                        <input type="password" class="form-control border-end-0" id="cvv" placeholder="CVV" maxlength="3" inputmode="numeric">
                                        <label for="cvv">Enter CVV</label>
                                    </div>
                                    <span class="input-group-text bg-white border-start-0" id="toggleCvv" style="cursor: pointer;">
                                        <i class="fa-solid fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body d-none">
                    <div class="wallet-card">
                        <div class="wallet-title mb-3"><i class="fa-solid fa-wallet"></i> Wallets</div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex gap-2">
                                            <img src="assets/images/phonepe.png" alt="payment">
                                            <p class="mb-0">Phonepe</p>
                                        </div>
                                        <div>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </div>
                                        <div class="old-ui-discount-badge">
                                            <div class="left discount-badge-upi"></div>
                                            <div class="badge-content discount-badge-upi"><span class="badge-text">Get 5% discount</span></div>
                                            <div class="right discount-badge-upi"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex gap-2">
                                            <img src="assets/images/amazon.png" alt="payment">
                                            <p class="mb-0">Amazon Pay</p>
                                        </div>
                                        <div>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </div>
                                        <div class="old-ui-discount-badge">
                                            <div class="left discount-badge-upi"></div>
                                            <div class="badge-content discount-badge-upi"><span class="badge-text">Get 5% discount</span></div>
                                            <div class="right discount-badge-upi"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex gap-2">
                                            <img src="assets/images/mobikwik.png" alt="payment">
                                            <p class="mb-0">Mobikwik</p>
                                        </div>
                                        <div>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </div>
                                        <div class="old-ui-discount-badge">
                                            <div class="left discount-badge-upi"></div>
                                            <div class="badge-content discount-badge-upi"><span class="badge-text">Get 5% discount</span></div>
                                            <div class="right discount-badge-upi"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex gap-2">
                                            <img src="assets/images/airtel.png" alt="payment">
                                            <p class="mb-0">Airtel Money</p>
                                        </div>
                                        <div>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </div>
                                        <div class="old-ui-discount-badge">
                                            <div class="left discount-badge-upi"></div>
                                            <div class="badge-content discount-badge-upi"><span class="badge-text">Get 5% discount</span></div>
                                            <div class="right discount-badge-upi"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body d-none">
                    <div class="wallet-card">
                        <div class="wallet-title mb-3"><i class="fa-solid fa-building-columns"></i> Select Your Bank</div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text  border-end-0 bg-white rounded-start-4"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    <input type="text" class="form-control border-start-0 py-3 rounded-end-4" id="bank_search" placeholder="Search">
                                </div>
                            </div>
                        </div>
                        <div class="bank-tab">
                            <a href="#populer_bank">Popular Bank</a>
                            <a href="#populer_bank">Other Bank</a>
                        </div>
                        <div id="populer_bank">
                            <h6 class="mb-2">Popular Bank</h6>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <a href="javascript:void(0);">
                                            <div class="d-flex gap-2">
                                                <img src="assets/images/amazon.png" alt="payment">
                                                <p class="mb-0">Amazon Pay</p>
                                            </div>
                                            <div>
                                                <i class="fa-solid fa-chevron-right"></i>
                                            </div>
                                            <div class="old-ui-discount-badge">
                                                <div class="left discount-badge-upi"></div>
                                                <div class="badge-content discount-badge-upi"><span class="badge-text">Get 5% discount</span></div>
                                                <div class="right discount-badge-upi"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <a href="javascript:void(0);">
                                            <div class="d-flex gap-2">
                                                <img src="assets/images/mobikwik.png" alt="payment">
                                                <p class="mb-0">Mobikwik</p>
                                            </div>
                                            <div>
                                                <i class="fa-solid fa-chevron-right"></i>
                                            </div>
                                            <div class="old-ui-discount-badge">
                                                <div class="left discount-badge-upi"></div>
                                                <div class="badge-content discount-badge-upi"><span class="badge-text">Get 5% discount</span></div>
                                                <div class="right discount-badge-upi"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <a href="javascript:void(0);">
                                            <div class="d-flex gap-2">
                                                <img src="assets/images/airtel.png" alt="payment">
                                                <p class="mb-0">Airtel Money</p>
                                            </div>
                                            <div>
                                                <i class="fa-solid fa-chevron-right"></i>
                                            </div>
                                            <div class="old-ui-discount-badge">
                                                <div class="left discount-badge-upi"></div>
                                                <div class="badge-content discount-badge-upi"><span class="badge-text">Get 5% discount</span></div>
                                                <div class="right discount-badge-upi"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="other_bank">
                            <h6 class="mb-2">Other Bank</h6>
                            <div class="row" >
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <a href="javascript:void(0);">
                                            <div class="d-flex gap-2">
                                                <img src="assets/images/amazon.png" alt="payment">
                                                <p class="mb-0">Amazon Pay</p>
                                            </div>
                                            <div>
                                                <i class="fa-solid fa-chevron-right"></i>
                                            </div>
                                            <div class="old-ui-discount-badge">
                                                <div class="left discount-badge-upi"></div>
                                                <div class="badge-content discount-badge-upi"><span class="badge-text">Get 5% discount</span></div>
                                                <div class="right discount-badge-upi"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <a href="javascript:void(0);">
                                            <div class="d-flex gap-2">
                                                <img src="assets/images/mobikwik.png" alt="payment">
                                                <p class="mb-0">Mobikwik</p>
                                            </div>
                                            <div>
                                                <i class="fa-solid fa-chevron-right"></i>
                                            </div>
                                            <div class="old-ui-discount-badge">
                                                <div class="left discount-badge-upi"></div>
                                                <div class="badge-content discount-badge-upi"><span class="badge-text">Get 5% discount</span></div>
                                                <div class="right discount-badge-upi"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <a href="javascript:void(0);">
                                            <div class="d-flex gap-2">
                                                <img src="assets/images/airtel.png" alt="payment">
                                                <p class="mb-0">Airtel Money</p>
                                            </div>
                                            <div>
                                                <i class="fa-solid fa-chevron-right"></i>
                                            </div>
                                            <div class="old-ui-discount-badge">
                                                <div class="left discount-badge-upi"></div>
                                                <div class="badge-content discount-badge-upi"><span class="badge-text">Get 5% discount</span></div>
                                                <div class="right discount-badge-upi"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-none">
                    <div class="checkout-footer">
                        <div class="form-check form-check-inline mb-2">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                            <label class="form-check-label" for="inlineCheckbox1">Send me order updates & offers - (no-spam)</label>
                        </div>
                        <div class="mb-2">
                            <button class="btn ak-btn w-100" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Continue</button>
                        </div>
                        <p>By proceeding, I agree to Gokwik's <a href="privacy-policy.php">Privacy Policy</a> and <a href="terms-of-service.php">T&c</a></p>
                    </div>
                </div>
                <div class="inner-modal" id="select-address-inner-modal">
                    <div class="inner-close">
                        <button type="button" class="btn" id="close-inner-modal-btn"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-lg-6">
                            <h6 class="mb-0">Select Delivery Address</h6>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="btn ak-outline-btn" id="open-add-address-modal"><i class="fa-solid fa-plus"></i> Add New Address</button>
                        </div>
                    </div>
                    <div id="address-list-container">
                        @if(isset($userAddresses) && count($userAddresses) > 0)
                            @foreach($userAddresses as $address)
                                @php
                                    $cityName = $address->city ?? '';
                                    $stateName = $address->state ?? '';
                                @endphp
                                <div class="address-box {{ $address->id == ($userAddress->id ?? null) ? 'selected' : '' }}" data-address-id="{{ $address->id }}">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <h6>{{ $address->name ?? 'Address' }} 
                                                @if($address->is_default ?? false)
                                                    <div class="badge"><span>Default</span></div>
                                                @endif
                                            </h6>
                                            <p>{{ $address->address ?? '' }}
                                                @if($cityName || $stateName)
                                                    <br>{{ $cityName }}{{ $stateName ? ', ' . $stateName : '' }}
                                                @endif
                                                @if($address->pincode)
                                                    , {{ $address->pincode }}
                                                @endif
                                            </p>
                                            <small>{{ $address->email ?? '' }}</small>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="javascript:void(0);" class="text-primary edit-address-btn" data-address-id="{{ $address->id }}"><i class="fa-solid fa-pen-to-square"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="address-box">
                                <div class="text-center py-3">
                                    <p class="mb-2">No addresses found. Please add your delivery address.</p>
                                    <button type="button" class="btn ak-btn" id="add-first-address-btn"><i class="fa-solid fa-plus"></i> Add Your First Address</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-logo">
                    <img src="assets/images/logo-3.png" alt="image not found">
                </div>
                <div class="checkout-process ms-auto">
                    <ul>
                        <li>Mobile ---</li>
                        <li>Address ---</li>
                        <li>pay</li>
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="discount-line">
                    Extra Discount Available at Payment Step
                </div>
                <div class="order-summary">
                    <div class="os-header">
                        <div>
                            <button type="button" class="btn ak-btn os-btn"><i class="fa-solid fa-cart-shopping"></i> Order Summary</button>
                        </div>
                        <div class="os-header-price">
                            @if(isset($mrpTotal) && $mrpTotal > ($subtotal ?? 0))
                                <del> ₹{{ number_format($mrpTotal, 2) }}</del>
                            @endif
                            <span>₹{{ number_format($subtotal ?? 0, 2) }}</span>
                        </div>
                    </div>
                    <div class="os-body">
                        @if(!empty($cart))
                            @foreach($cart as $productId => $item)
                                @php
                                    $itemPrice = $item['price'] ?? 0;
                                    $itemDiscountedPrice = $item['discounted_price'] ?? $itemPrice;
                                    $itemQty = $item['qnty'] ?? 1;
                                @endphp
                                <div class="os-product-detail">
                                    <div class="os-product">
                                        <img src="{{ asset('product/' . ($item['image'] ?? '')) }}" alt="{{ $item['title'] ?? '' }}">
                                    </div>
                                    <div>
                                        <div class="os-product-name">
                                            {{ $item['title'] ?? 'Product' }}
                                        </div>
                                        <div class="os-price">Price: <span> 
                                            @if($itemPrice > $itemDiscountedPrice)
                                                <del> ₹{{ number_format($itemPrice, 2) }}</del>
                                            @endif
                                            ₹{{ number_format($itemDiscountedPrice, 2) }}
                                        </span></div>
                                        <div class="os-qty">Quantity: {{ $itemQty }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="price-summary">
                            <ul>
                                <li>
                                    <span>MRP Total</span> ₹{{ number_format($mrpTotal ?? 0, 2) }}
                                </li>
                                @if(($totalDiscount ?? 0) > 0)
                                    <li>
                                        <span>Discount on MRP</span> ₹{{ number_format($totalDiscount ?? 0, 2) }}
                                    </li>
                                @endif
                                <li>
                                    <span>Subtotal</span> ₹{{ number_format($subtotal ?? 0, 2) }}
                                </li>
                                <li>
                                    <span>Shipping</span> To be calculated
                                </li>
                                <li>
                                    <span>To Pay</span> ₹{{ number_format($subtotal ?? 0, 2) }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="coupon-add">
                    <div>
                        <span class="input-group-text" id=""><i class="fa-solid fa-percent"></i></span>
                    </div>
                    <div class="form-floating ">
                        <input type="search" class="form-control" id="coupon" placeholder="ENTER COUPON CODE">
                        <label for="coupon">Email address</label>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div><i class="fa-regular fa-circle-user"></i> Login to continue</div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">+91</span>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="mobile_number" placeholder="Mobile Number">
                                <label for="mobile_number">Enter Mobile Number</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="checkout-footer">
                    <div>
                        <button class="btn ak-btn w-100" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Open second modal</button>
                    </div>
                    <p>By proceeding, I accept that i have read and understood the Gokwik's <a href="privacy-policy.php">Privacy Policy</a> and <a href="terms-of-service.php">T&c</a></p>
                    <div class="t-c">
                        <div>
                            T&C | Privacy
                            <br>
                            3fff98bd2
                        </div>
                        <div>
                            Powered By
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Add New Address Modal - Separate Popup -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-address-form">
                    <input type="hidden" id="edit_address_id" name="edit_address_id" value="">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" >
                                <label for="first_name">First Name *</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="address" name="address" placeholder="Address" style="height: 80px" ></textarea>
                                <label for="address">Address *</label>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="apartment" name="apartment" placeholder="Apartment, Area, Sector, Village">
                                <label for="apartment">Apartment, Area, Sector, Village</label>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="country" name="country" placeholder="Country" value="India">
                                <label for="country">Country *</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="state" name="state" placeholder="State">
                                <label for="state">State *</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="city" name="city" placeholder="City">
                                <label for="city">City *</label>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" maxlength="10">
                                <label for="pincode">Pincode</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn ak-outline-btn" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn ak-btn" id="submit-address-btn">Save Address</button>
            </div>
        </div>
    </div>
</div>

@include('front.layouts.footer')
<style>
    /* Remove overlay when inner-modal is closed */
    .checkout-modal .modal-content.inner-modal-closed::before {
        display: none !important;
        background-color: transparent !important;
    }
    
    /* Show overlay only when inner-modal is open */
    .checkout-modal .modal-content.has-inner-modal::before {
        display: block;
        background-color: rgba(0, 0, 0, 0.4);
    }
    
    /* Ensure modal body is accessible when inner-modal is closed */
    .checkout-modal .modal-content.inner-modal-closed ~ .modal-body,
    .checkout-modal.inner-modal-closed .modal-body {
        pointer-events: auto !important;
        overflow-y: auto !important;
    }
    
    /* Make all form elements accessible when inner-modal is closed */
    .checkout-modal.inner-modal-closed .modal-body input,
    .checkout-modal.inner-modal-closed .modal-body textarea,
    .checkout-modal.inner-modal-closed .modal-body select,
    .checkout-modal.inner-modal-closed .modal-body button,
    .checkout-modal.inner-modal-closed .modal-body a,
    .checkout-modal.inner-modal-closed .modal-body .card,
    .checkout-modal.inner-modal-closed .modal-body .delivery-box,
    .checkout-modal.inner-modal-closed .modal-body .coupon-add,
    .checkout-modal.inner-modal-closed .modal-body .payment-offer,
    .checkout-modal.inner-modal-closed .modal-body .upi-details {
        pointer-events: auto !important;
        opacity: 1 !important;
        position: relative !important;
        z-index: auto !important;
    }
</style>
<script>
    // Check if user is logged in
    const isUserLoggedIn = @json(Auth::check());
    const loginUrl = '{{ route("user.login") }}';

    $(document).ready(function() {
        $(".os-btn").on("click", function() {
            let $btn = $(this);
            let $body = $btn.closest(".order-summary").find(".os-body");

            $body.slideToggle(300, function() {
                $btn.toggleClass("active", $body.is(":visible"));
            });
        });

        // Checkout button click handler
        $(document).on('click', '#checkout-btn', function(e) {
            e.preventDefault();
            if (isUserLoggedIn) {
                // User is logged in, open the checkout modal
                const checkoutModal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
                checkoutModal.show();
            } else {
                // User is not logged in, redirect to login page
                window.location.href = loginUrl;
            }
        });
    });

    // Cart functionality
    $(document).ready(function() {
        // Update quantity
        $(document).on('click', '.qty-btn.plus', function() {
            const productId = $(this).data('product-id');
            const input = $(this).siblings('.qty-input');
            const currentQty = parseInt(input.val()) || 1;
            input.val(currentQty + 1);
            updateCartQuantity(productId, currentQty + 1);
        });

        $(document).on('click', '.qty-btn.minus', function() {
            const productId = $(this).data('product-id');
            const input = $(this).siblings('.qty-input');
            const currentQty = parseInt(input.val()) || 1;
            if (currentQty > 1) {
                input.val(currentQty - 1);
                updateCartQuantity(productId, currentQty - 1);
            }
        });

        // Delete item
        $(document).on('click', '.delete-btn', function() {
            const productId = $(this).data('product-id');
            if (confirm('Are you sure you want to remove this item from cart?')) {
                removeFromCart(productId);
            }
        });

        function updateCartQuantity(productId, quantity) {
            $.ajax({
                url: '{{ route("update.to.cart") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: productId,
                    qnty: quantity
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Error updating cart. Please try again.');
                }
            });
        }

        function removeFromCart(productId) {
            $.ajax({
                url: '{{ route("cart.remove") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId
                },
                success: function(response) {
                    if (typeof showCartNotification === 'function') {
                        showCartNotification('Product removed from cart');
                    }
                    location.reload();
                },
                error: function() {
                    alert('Error removing item. Please try again.');
                }
            });
        }
    });
</script>
<script>
    const toggleCvv = document.getElementById('toggleCvv');
    const cvvInput = document.getElementById('cvv');

    toggleCvv.addEventListener('click', function() {
        const icon = this.querySelector('i');

        if (cvvInput.type === 'password') {
            cvvInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            cvvInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    // Add New Address Modal Functionality
    $(document).ready(function() {
        // Open add address modal using Bootstrap modal
        $(document).on('click', '#open-add-address-modal, #add-first-address-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            // Reset form for new address
            $('#add-address-form')[0].reset();
            $('#edit_address_id').val('');
            $('#country').val('India');
            $('#addAddressModalLabel').text('Add New Address');
            $('#submit-address-btn').text('Save Address');
            const addAddressModal = new bootstrap.Modal(document.getElementById('addAddressModal'));
            addAddressModal.show();
        });

        // Edit address button click - load address data
        $(document).on('click', '.edit-address-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const addressId = $(this).data('address-id');
            if (addressId) {
                loadAddressForEdit(addressId);
            }
        });

        // Function to load address for editing
        function loadAddressForEdit(addressId) {
            $.ajax({
                url: '{{ url("/address/get") }}/' + addressId,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success' && response.address) {
                        const addr = response.address;
                        // Fill form with address data
                        $('#edit_address_id').val(addr.id);
                        $('#first_name').val(addr.first_name || '');
                        $('#email').val(addr.email || '');
                        $('#address').val(addr.address || '');
                        $('#apartment').val(addr.apartment || '');
                        $('#country').val(addr.country || 'India');
                        // Use state_name and city_name for text fields, fallback to state/city if names not available
                        $('#state').val(addr.state_name || addr.state || '');
                        $('#city').val(addr.city_name || addr.city || '');
                        $('#pincode').val(addr.pincode || '');
                        
                        // Update modal title
                        $('#addAddressModalLabel').text('Edit Address');
                        $('#submit-address-btn').text('Update Address');
                        
                        // Open modal
                        const addAddressModal = new bootstrap.Modal(document.getElementById('addAddressModal'));
                        addAddressModal.show();
                    }
                },
                error: function() {
                    alert('Error loading address. Please try again.');
                }
            });
        }

        // Reset form when modal is closed
        $('#addAddressModal').on('hidden.bs.modal', function () {
            $('#add-address-form')[0].reset();
            $('#edit_address_id').val('');
            $('#country').val('India'); // Reset to default
            $('#addAddressModalLabel').text('Add New Address');
            $('#submit-address-btn').text('Save Address');
        });


        // Submit add address form
        $(document).on('click', '#submit-address-btn', function(e) {
            e.preventDefault();
            const form = $('#add-address-form');
            
            // Validate form
            if (!form[0].checkValidity()) {
                form[0].reportValidity();
                return;
            }
            
            const formData = form.serialize();
            const submitBtn = $(this);
            const originalText = submitBtn.text();
            const editAddressId = $('#edit_address_id').val();
            
            submitBtn.prop('disabled', true).text('Saving...');
            
            // Determine URL - edit or create
            const url = editAddressId ? '{{ url("/address/update") }}/' + editAddressId : '{{ route("user.address.store") }}';
            
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Close only the address modal (not other modals)
                        const addAddressModal = bootstrap.Modal.getInstance(document.getElementById('addAddressModal'));
                        if (addAddressModal) {
                            addAddressModal.hide();
                        }
                        form[0].reset();
                        $('#edit_address_id').val('');
                        $('#country').val('India'); // Reset to default
                        $('#addAddressModalLabel').text('Add New Address');
                        $('#submit-address-btn').text('Save Address');
                        
                        // Show success message
                        if (typeof showCartNotification === 'function') {
                            showCartNotification(response.message || 'Address saved successfully!');
                        } else {
                            alert(response.message || 'Address saved successfully!');
                        }
                        
                        // Update address list dynamically without page reload
                        updateAddressList(response.address);
                        
                        // Update delivery details section with new/updated address
                        if (response.address) {
                            updateDeliveryDetailsAfterSave(response.address);
                            // Update delivery charge based on new address pincode
                            if (response.address.pincode) {
                                updateDeliveryCharge(response.address.pincode);
                            }
                        }
                        
                        submitBtn.prop('disabled', false).text(originalText);
                    } else {
                        alert(response.message || 'Error saving address');
                        submitBtn.prop('disabled', false).text(originalText);
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Error adding address. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = Object.values(xhr.responseJSON.errors).flat();
                        errorMsg = errors.join('\n');
                    }
                    alert(errorMsg);
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });

        // Function to update address list dynamically
        function updateAddressList(newAddress) {
            const addressListContainer = $('#address-list-container');
            
            // If no addresses exist, remove the empty message
            if (addressListContainer.find('.text-center').length > 0) {
                addressListContainer.empty();
            }
            
            // Build address HTML
            const cityName = newAddress.city_name || newAddress.city || '';
            const stateName = newAddress.state_name || newAddress.state || '';
            const addressHtml = `
                <div class="address-box ${newAddress.is_default ? 'selected' : ''}" data-address-id="${newAddress.id}">
                    <div class="row">
                        <div class="col-lg-10">
                            <h6>${newAddress.name || 'Address'} 
                                ${newAddress.is_default ? '<div class="badge"><span>Default</span></div>' : ''}
                            </h6>
                            <p>${newAddress.address || ''}
                                ${cityName || stateName ? '<br>' + cityName + (stateName ? ', ' + stateName : '') : ''}
                                ${newAddress.pincode ? ', ' + newAddress.pincode : ''}
                            </p>
                            <small>${newAddress.email || ''}</small>
                        </div>
                        <div class="col-lg-2">
                            <a href="javascript:void(0);" class="text-primary edit-address-btn" data-address-id="${newAddress.id}"><i class="fa-solid fa-pen-to-square"></i></a>
                        </div>
                    </div>
                </div>
            `;
            
            // Check if address already exists (for edit)
            const existingAddress = addressListContainer.find(`[data-address-id="${newAddress.id}"]`);
            if (existingAddress.length > 0) {
                existingAddress.replaceWith(addressHtml);
            } else {
                addressListContainer.append(addressHtml);
            }
        }

        // Function to update delivery details after address save
        function updateDeliveryDetailsAfterSave(address) {
            // Update the delivery details section in checkout modal
            const addressText = address.address || 'Address not set';
            const cityName = address.city_name || address.city || '';
            const stateName = address.state_name || address.state || '';
            const countryName = address.country_name || address.country || '';
            
            let fullAddress = addressText;
            if (cityName || stateName) {
                fullAddress += '<br>' + cityName + (stateName ? ', ' + stateName : '');
            }
            if (address.pincode) {
                fullAddress += ', ' + address.pincode;
            }
            
            const deliveryDetailsHtml = `
                <div><i class="fa-solid fa-location-dot"></i></div>
                <div>
                    <h6>Deliver TO ${address.name || 'Customer'}</h6>
                    <p>${fullAddress}</p>
                    <span>{{ $user->phone ?? '' }} | ${address.email || '{{ $user->email ?? '' }}'}</span>
                </div>
            `;
            
            $('.customer-address-details').html(deliveryDetailsHtml);
        }

        // Close inner modal when close button is clicked
        $(document).on('click', '#close-inner-modal-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const innerModal = $('#select-address-inner-modal');
            innerModal.fadeOut(300, function() {
                innerModal.hide();
                
                // Remove inner-modal completely from blocking
                innerModal.css({
                    'display': 'none',
                    'pointer-events': 'none',
                    'visibility': 'hidden'
                });
                
                // Get modal elements
                const checkoutModal = $('#exampleModalToggle');
                const modalContent = $('.checkout-modal .modal-content');
                const modalBody = $('.checkout-modal .modal-body');
                
                // Add class to checkout modal to indicate inner-modal is closed
                checkoutModal.addClass('inner-modal-closed').removeClass('has-inner-modal');
                modalContent.removeClass('has-inner-modal').addClass('inner-modal-closed');
                
                // Remove any blocking styles
                modalContent.css({
                    'position': '',
                    'z-index': ''
                });
                
                // Ensure modal body is fully accessible
                modalBody.css({
                    'pointer-events': 'auto',
                    'overflow-y': 'auto',
                    'position': 'relative',
                    'z-index': 'auto',
                    'opacity': '1'
                });
                
                // Make all interactive elements accessible
                modalBody.find('input, textarea, select, button, a, .card, .delivery-box, .coupon-add, .payment-offer, .upi-details, .payment-selection, .card-body').each(function() {
                    $(this).css({
                        'pointer-events': 'auto',
                        'opacity': '1',
                        'position': 'relative',
                        'z-index': 'auto'
                    });
                });
                
                // Force browser reflow to apply changes
                if (modalBody[0]) modalBody[0].offsetHeight;
                if (modalContent[0]) modalContent[0].offsetHeight;
            });
        });

        // Show inner modal when Change button is clicked
        $(document).on('click', '#show-address-selector-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const innerModal = $('#select-address-inner-modal');
            const checkoutModal = $('#exampleModalToggle');
            const modalContent = $('.checkout-modal .modal-content');
            
            // Add class to indicate inner-modal is open
            checkoutModal.addClass('has-inner-modal').removeClass('inner-modal-closed');
            modalContent.addClass('has-inner-modal').removeClass('inner-modal-closed');
            
            // Show inner modal
            innerModal.css({
                'display': 'block',
                'pointer-events': 'auto',
                'visibility': 'visible'
            }).hide().fadeIn(300);
        });

        // QR Code Show/Hide functionality
        $(document).on('click', '#show-qr-code-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const qrImage = $('#qr-code-image');
            const qrButton = $(this);
            
            if (qrImage.hasClass('blur')) {
                // Remove blur to show QR code
                qrImage.removeClass('blur');
                qrButton.html('<i class="fa-solid fa-eye-slash"></i> Click to hide QR code');
            } else {
                // Add blur to hide QR code
                qrImage.addClass('blur');
                qrButton.html('<i class="fa-solid fa-eye"></i> Click to see QR code');
            }
        });

        // Function to update delivery charge and amounts when address changes
        function updateDeliveryCharge(pincode) {
            if (!pincode) {
                // Default delivery charge if no pincode
                updateAmounts(100);
                return;
            }
            
            $.get('{{ route("get.shipping.charge") }}', { pincode: pincode }, function(response) {
                const deliveryCharge = response.shippingCharge || 100;
                updateAmounts(deliveryCharge);
            }).fail(function() {
                // Default to ₹100 if API fails
                updateAmounts(100);
            });
        }

        // Function to update all payment amounts based on delivery charge
        function updateAmounts(deliveryCharge) {
            const subtotal = {{ $subtotal ?? 0 }};
            const prepaidSubtotal = subtotal * 0.95; // 5% discount
            const prepaidTotal = prepaidSubtotal + deliveryCharge;
            
            // Update UPI amount
            const prepaidParts = prepaidTotal.toFixed(2).split('.');
            $('#prepaid-amount-display').html(`₹${prepaidParts[0]}. <span class="decimal-price">${prepaidParts[1] || '00'}</span>`);
            
            // Update Debit/Credit Cards amount
            $('#debit-card-amount').html(`₹${prepaidTotal.toFixed(2)} <i class="fa-solid fa-chevron-right"></i>`);
            
            // Update Wallets amount
            $('#wallet-amount').html(`₹${prepaidTotal.toFixed(2)} <i class="fa-solid fa-chevron-right"></i>`);
            
            // Update Netbanking amount
            $('#netbanking-amount').html(`₹${prepaidTotal.toFixed(2)} <i class="fa-solid fa-chevron-right"></i>`);
            
            // Update delivery charge display
            $('#delivery-charge-display').text(`₹${deliveryCharge.toFixed(2)}`);
            
            // Update COD amount
            $('#cod-amount-display').html(`₹${deliveryCharge.toFixed(2)} <i class="fa-solid fa-chevron-right"></i>`);
            $('#cod-payment-info').html(`₹${deliveryCharge.toFixed(2)} advance + ₹${subtotal.toFixed(2)} on delivery`);
        }

        // Update delivery charge when address is selected/changed
        $(document).on('click', '.address-box', function() {
            const addressId = $(this).data('address-id');
            if (addressId) {
                // Get pincode from selected address
                const addressText = $(this).find('p').text();
                const pincodeMatch = addressText.match(/\d{6}/);
                if (pincodeMatch && pincodeMatch[0]) {
                    updateDeliveryCharge(pincodeMatch[0]);
                }
            }
        });

        // Update delivery charge on page load if user has address
        $(document).ready(function() {
            @if($userAddress && $userAddress->pincode)
                updateDeliveryCharge('{{ $userAddress->pincode }}');
            @else
                updateDeliveryCharge(100); // Default
            @endif
        });
    });
</script>
