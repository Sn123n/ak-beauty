@include('front.dashboard.header')
<div class="main dashboard">
    <section class="order-detail">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="back-link mb-4">
                        <a href="{{ route('user.order') }}" class="btn btn-outline">
                            <i class="fas fa-arrow-left me-2"></i> Back to Orders
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="order-info-card">
                        <h3>Order Information</h3>
                        <div class="order-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Order ID:</strong> #{{ $order->order_id ?? $order->id }}</p>
                                    <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y h:i A') }}</p>
                                    <p><strong>Payment Method:</strong> {{ $order->payment_method ?? 'Cash on Delivery' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Order Status:</strong> 
                                        <span class="badge bg-{{ $order->status_color ?? 'secondary' }}">
                                            {{ $order->status ?? 'Pending' }}
                                        </span>
                                    </p>
                                    @if($order->estimated_delivery_date)
                                        <p><strong>Estimated Delivery:</strong> {{ \Carbon\Carbon::parse($order->estimated_delivery_date)->format('M d, Y') }}</p>
                                    @endif
                                    @if($order->tracking_number)
                                        <p><strong>Tracking Number:</strong> {{ $order->tracking_number }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <h4 class="mt-4">Order Items</h4>
                        <div class="order-items">
                            @if($order->orderDetails)
                                @foreach($order->orderDetails as $item)
                                    <div class="order-item">
                                        <div class="item-image">
                                            <img src="{{ asset('product/' . $item->product->image) }}" alt="{{ $item->product->title }}">
                                        </div>
                                        <div class="item-details">
                                            <h6>{{ $item->product->title }}</h6>
                                            <p>Quantity: {{ $item->quantity }}</p>
                                            <p>Price: Rs. {{ number_format($item->price, 2) }}</p>
                                        </div>
                                        <div class="item-total">
                                            <strong>Rs. {{ number_format($item->quantity * $item->price, 2) }}</strong>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>No items found for this order.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="order-summary-card">
                        <h3>Order Summary</h3>
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>Rs. {{ number_format($order->subtotal ?? 0, 2) }}</span>
                        </div>
                        @if($order->shipping_charge > 0)
                            <div class="summary-row">
                                <span>Shipping</span>
                                <span>Rs. {{ number_format($order->shipping_charge, 2) }}</span>
                            </div>
                        @endif
                        @if($order->discount_amount > 0)
                            <div class="summary-row discount">
                                <span>Discount</span>
                                <span>-Rs. {{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                        @endif
                        <div class="summary-row total">
                            <span><strong>Total</strong></span>
                            <span><strong>Rs. {{ number_format($order->total_amount ?? 0, 2) }}</strong></span>
                        </div>

                        <div class="shipping-address">
                            <h4>Shipping Address</h4>
                            <p>
                                {{ $order->first_name ?? '' }} {{ $order->last_name ?? '' }}<br>
                                {{ $order->address ?? '' }}<br>
                                @if($order->address2) {{ $order->address2 }}<br>@endif
                                {{ $order->city_name ?? '' }}, {{ $order->state_name ?? '' }}<br>
                                {{ $order->country_name ?? '' }} - {{ $order->pincode ?? '' }}<br>
                                Phone: {{ $order->phone ?? '' }}
                            </p>
                        </div>

                        <div class="order-actions">
                            @if($order->status === 'pending')
                                <button class="btn btn-danger btn-sm w-100" onclick="cancelOrder({{ $order->id }})">
                                    Cancel Order
                                </button>
                            @endif
                            @if($order->status === 'delivered')
                                <button class="btn btn-primary btn-sm w-100" onclick="reviewProducts({{ $order->id }})">
                                    Write Review
                                </button>
                            @endif
                            @if($order->invoice_path)
                                <a href="{{ asset($order->invoice_path) }}" class="btn btn-outline btn-sm w-100" target="_blank">
                                    Download Invoice
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
function cancelOrder(orderId) {
    if (confirm('Are you sure you want to cancel this order?')) {
        $.post('/orders/cancel/' + orderId, function(response) {
            if (response.success) {
                alert('Order cancelled successfully');
                location.reload();
            } else {
                alert('Failed to cancel order: ' + response.message);
            }
        });
    }
}

function reviewProducts(orderId) {
    window.location.href = '/orders/review/' + orderId;
}
</script>

@include('front.dashboard.footer')
