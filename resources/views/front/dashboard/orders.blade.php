@include('front.dashboard.header')
<div class="main dashboard">
    <section class="user-orders">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-6">
                    <div class="sec-title text-start">
                        <h3 class="section-main-title">
                            My Orders
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-6">
                    <div class="d-flex float-end gap-2">
                        <div class="custom-select d-none d-md-flex order-list-change">
                            <div class="dropdown custom-select-filter">
                                <button class="btn btn-light dropdown-toggle d-flex align-items-center w-100" type="button" id="viewDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-th-large me-2"></i> Gallery
                                </button>
                                <ul class="dropdown-menu p-2" aria-labelledby="viewDropdown">
                                    <li class="active rounded-3">
                                        <a class="dropdown-item text-gray d-flex align-items-center rounded-3" href="#" onclick="setView('gallery')">
                                            <i class="fas fa-th-large me-2"></i> Gallery <i class="fa-solid fa-check ms-auto"></i>
                                        </a>
                                    </li>
                                    <li class="rounded-3">
                                        <a class="dropdown-item text-gray d-flex align-items-center rounded-3" href="#" onclick="setView('list')">
                                            <i class="fas fa-list-ul me-2"></i> List
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="order-filter" class="pointer" data-bs-toggle="offcanvas" data-bs-target="#orderlist" aria-controls="orderlist">
                            <a href="javascript:void">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row" id="orders-container">
                @forelse($orders as $order)
                    <div class="col-lg-4 col-md-6">
                        <div class="order-card pointer" data-href="{{ route('order.details', $order->id) }}">
                            <a href="javascript:void(0);">
                                <div class="order-status d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-{{ $order->status_color ?? 'secondary' }}">
                                            {{ $order->status ?? 'Pending' }}
                                        </span>
                                        <span class="order-id">#{{ $order->order_id ?? $order->id }}</span>
                                    </div>
                                    <span class="order-date">{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</span>
                                </div>
                                <div class="order-content">
                                    <div class="order-image">
                                        @if($order->orderDetails && $order->orderDetails->first())
                                            <img src="{{ asset('product/' . $order->orderDetails->first()->product->image) }}" alt="{{ $order->orderDetails->first()->product->title }}">
                                        @else
                                            <img src="{{ asset('client_assets/images/no-image.png') }}" alt="Product">
                                        @endif
                                    </div>
                                    <div class="order-info">
                                        <h6>{{ $order->orderDetails->count() ?? 0 }} Items</h6>
                                        <p>Total: Rs. {{ number_format($order->total_amount ?? 0, 2) }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state text-center py-5">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <h4>No Orders Yet</h4>
                            <p class="text-muted">You haven't placed any orders yet. Start shopping to see your orders here.</p>
                            <a href="{{ route('product.list') }}" class="btn btn-primary">Start Shopping</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>

<!-- Order Filter Offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="orderlist" aria-labelledby="orderlistLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="orderlistLabel">Filter Orders</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <h6>Order Status</h6>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="status-all" checked>
            <label class="form-check-label" for="status-all">All Orders</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="status-pending">
            <label class="form-check-label" for="status-pending">Pending</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="status-processing">
            <label class="form-check-label" for="status-processing">Processing</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="status-shipped">
            <label class="form-check-label" for="status-shipped">Shipped</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="status-delivered">
            <label class="form-check-label" for="status-delivered">Delivered</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="status-cancelled">
            <label class="form-check-label" for="status-cancelled">Cancelled</label>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Order card click handler
    $('.order-card').click(function() {
        var href = $(this).data('href');
        if (href) {
            window.location.href = href;
        }
    });

    // View toggle
    function setView(view) {
        $('#viewDropdown .dropdown-item').removeClass('active');
        $('#viewDropdown .dropdown-item').each(function() {
            if ($(this).text().toLowerCase().includes(view)) {
                $(this).addClass('active');
                $(this).find('.fa-check').show();
            } else {
                $(this).find('.fa-check').hide();
            }
        });
        
        if (view === 'list') {
            $('#orders-container').removeClass('gallery-view').addClass('list-view');
        } else {
            $('#orders-container').removeClass('list-view').addClass('gallery-view');
        }
    }

    // Filter orders
    $('.form-check-input').change(function() {
        // Add filter logic here
        console.log('Filter changed');
    });
});
</script>

@include('front.dashboard.footer')
