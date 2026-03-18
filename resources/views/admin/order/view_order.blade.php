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
                                <h4 class="header-title">Order Detail</h4>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row pb-25">
                                <div class="col-lg-12">
                                    <h1 class="order-number">Order# {{ $order->order_id }}</h1>
                                    <p>Order Date: {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <h3 class="bill-title">Billing Address</h3>
                                    <ul class="billing">
                                        <li>
                                            <div class="billing-name">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-3">
                                                        <label>Name:</label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-9">
                                                        <p>{{ $order->user->name ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="billing-email">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-3">
                                                        <label>Email:</label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-9">
                                                        <p>{{ $order->user->email ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="billing-phone">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-3">
                                                        <label>Phone:</label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-9">
                                                        <p>{{ $order->user->phone ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="billing-address">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-3">
                                                        <label>Address:</label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-9">
                                                        <p>{{ $order->user->address ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <h3 class="bill-title">Payment Information</h3>
                                    <ul class="payment">
                                        <li>
                                            <div class="payment-status">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-5">
                                                        <label>Payment Status:</label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-7">
                                                        <p>{{ ucfirst($order->payment_status) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="payment-amount">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-5">
                                                        <label>Payment Amount:</label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-7">
                                                        <p>Rs {{ number_format($order->total_amount, 2) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="payment-method">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-5">
                                                        <label>Payment Method:</label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-7">
                                                        <p>{{ ucfirst($order->payment_method) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @if (session('success'))
                                <div class="alert alert-success1" id="successMessage">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger" id="errorMessage">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div id="errorMessage" class="alert alert-danger d-none"></div>
                            <div id="ajaxMessage" class="alert d-none alert alert-success1"></div>

                            <div class="dt-responsive">
                                <table id="example" class="table table-bordered" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th class="sr" data-priority="1">Sr</th>
                                            <th class="table-img">Image</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th class="action" data-priority="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order_details as $key => $detail)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <img src="{{ asset('product/' . $detail->product->image) }}"
                                                        alt="Product Image" class="table-img"
                                                        onerror="this.onerror=null;this.src='{{ asset('assets/images/default-product.jpg') }}';">
                                                </td>
                                                <td>{{ $detail->product->title }}</td>
                                                <td>Rs {{ number_format($detail->price, 2) }}</td>
                                                <td>{{ $detail->quantity }}</td>
                                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <select name="status" class="form-select"
                                                        data-order-id="{{ $order->id }}"
                                                        data-order-detail-id="{{ $detail->id }}">
                                                        <option value="pending"
                                                            {{ $detail->status == 'pending' ? 'selected' : '' }}>Pending
                                                        </option>
                                                        <option value="accept"
                                                            {{ $detail->status == 'accept' ? 'selected' : '' }}>
                                                            Accept</option>
                                                        <option value="cancelled"
                                                            {{ $detail->status == 'cancelled' ? 'selected' : '' }}>
                                                            Cancelled</option>
                                                        <option value="shipped"
                                                            {{ $detail->status == 'shipped' ? 'selected' : '' }}>Shipped
                                                        </option>
                                                        <option value="delivered"
                                                            {{ $detail->status == 'delivered' ? 'selected' : '' }}>
                                                            Delivered</option>



                                                        {{-- <option value="processing"
                                                            {{ $detail->status == 'processing' ? 'selected' : '' }}>
                                                            Processing</option> --}}
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="action-btn">
                                                        <form action="{{ route('orderdetail.delete', $detail->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="delete btn">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
        </div> <!-- container -->
    </div>
    <!-- content -->

    {{-- popup modal --}}
    <!-- Modal -->
    <div class="modal fade" id="acceptOrderModal" tabindex="-1" aria-labelledby="acceptOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="acceptOrderModalLabel">Set Estimated Delivery Date</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="acceptOrderForm">
                        @csrf
                        <input type="hidden" name="order_id" id="modal_order_id">
                        <input type="hidden" name="order_detail_id" id="modal_order_detail_id">
                        <div class="mb-3">
                            <label for="estimated_date" class="form-label">Estimated Delivery Date</label>
                            <input type="date" class="form-control" name="estimated_delivery_date"
                                id="estimated_date" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Date</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Cancel Modal --}}
    <div class="modal fade" id="cancleOrderModal" tabindex="-1" aria-labelledby="cancleOrderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="acceptOrderModalLabel">Set Cancelled Reason</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cancleOrderForm">
                        @csrf
                        <input type="hidden" name="order_id" id="cancle_order_id">
                        <input type="hidden" name="order_detail_id" id="cancle_order_detail_id">
                        <div class="mb-3">
                            <label for="estimated_date" class="form-label">Reason</label>
                            <textarea type="text" class="form-control" name="reason" id="estimated_date"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @include('admin.layouts.footer')
    <script>
       $(document).ready(function() {
            if ($(window).width() < 1100) {
                $('#example').DataTable({
                    responsive: true,
                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 0
                        },
                        {
                            responsivePriority: 2,
                            targets: -1
                        }
                    ]
                });
            } else {
                $('#example').DataTable({
                    responsive: false,
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            let previousStatus = {};

            // Track the previous status when the select is focused
            $(document).on('focus', 'select[name="status"]', function() {
                const id = $(this).data('order-detail-id');
                previousStatus[id] = $(this).val();
            });

            $(document).on('change', 'select[name="status"]', function() {
                const selectedStatus = $(this).val();
                console.log('Selected status:', selectedStatus);
                const orderId = $(this).data('order-id');
                const orderDetailId = $(this).data('order-detail-id');
                const $select = $(this);

                if (selectedStatus === 'accept') {

                    $('#modal_order_id').val(orderId);
                    $('#modal_order_detail_id').val(orderDetailId);
                    $('#acceptOrderModal').modal('show');
                } else if (selectedStatus === 'cancelled') {
                    console.log('Opening Cancel modal');
                    $('#cancle_order_id').val(orderId);
                    $('#cancle_order_detail_id').val(orderDetailId);
                    $('#cancleOrderModal').modal('show');
                } else {

                    updateOrderStatus(orderId, orderDetailId, selectedStatus, $select);
                }
            });

            $('#acceptOrderForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('orders.setEstimatedDate') }}",
                    method: "POST",
                    data: formData,
                    success: function() {
                        $('#acceptOrderModal').modal('hide');
                        const orderId = $('#modal_order_id').val();
                        const orderDetailId = $('#modal_order_detail_id').val();
                        const selectedStatus = 'accept';
                        const $select = $('select[data-order-detail-id="' + orderDetailId +
                            '"]');

                        updateOrderStatus(orderId, orderDetailId, selectedStatus, $select);
                        showSuccess("Estimated delivery date saved successfully.");
                    },
                    error: function() {
                        showError("Failed to save estimated delivery date.");
                    }
                });
            });

            // Handle Cancel modal form submission
            $('#cancleOrderForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('orders.savereason') }}", // Ensure this route exists
                    method: "POST",
                    data: formData,
                    success: function() {
                        $('#cancleOrderModal').modal('hide');
                        const orderId = $('#cancle_order_id').val();
                        const orderDetailId = $('#cancle_order_detail_id').val();
                        const selectedStatus = 'cancelled';
                        const $select = $('select[data-order-detail-id="' + orderDetailId +
                            '"]');

                        updateOrderStatus(orderId, orderDetailId, selectedStatus, $select);
                        showSuccess("Order cancelled successfully.");
                    },
                    error: function() {
                        showError("Failed to cancel the order.");
                    }
                });
            });

            // Update order status via Ajax
            function updateOrderStatus(orderId, orderDetailId, status, $select) {
                $.ajax({
                    url: "{{ route('order.updateStatus') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        order_detail_id: orderDetailId,
                        order_id: orderId,
                        status: status
                    },
                    success: function(response) {
                        console.log("AJAX success response:", response); // Debug
                        $('#errorMessage').hide();
                        $select.val(response.status);
                        showSuccess(response.message || "Status updated successfully.");
                    },
                    error: function(xhr) {
                        let error = "Something went wrong!";
                        if (xhr.status === 422 && xhr.responseJSON.error) {
                            error = xhr.responseJSON.error;
                        }

                        showError(error);
                        $select.val(previousStatus[orderDetailId]);
                    }
                });
            }

            // Show error message
            function showError(message) {
                $('#errorMessage')
                    .text(message)
                    .removeClass('d-none')
                    .show();

                setTimeout(function() {
                    $('#errorMessage').fadeOut(function() {
                        $(this).addClass('d-none');
                    });
                }, 5000);
            }

            // Show success message
            function showSuccess(message) {
                $('#ajaxMessage')
                    .text(message)
                    .removeClass('d-none alert-danger')
                    .addClass('alert-success1')
                    .show();

                setTimeout(function() {
                    $('#ajaxMessage').fadeOut(function() {
                        $(this).addClass('d-none').removeClass('alert-success1');
                    });
                }, 5000);
            }
        });
    </script>


    {{-- <script>
        $(document).ready(function() {
            let previousStatus = {};

            $(document).on('focus', 'select[name="status"]', function() {
                const id = $(this).data('order-detail-id');
                previousStatus[id] = $(this).val();
            });

            $(document).on('change', 'select[name="status"]', function() {
                const selectedStatus = $(this).val();
                const orderId = $(this).data('order-id');
                const orderDetailId = $(this).data('order-detail-id');
                const $select = $(this);

                if (selectedStatus === 'accept') {
                    $('#modal_order_id').val(orderId);
                    $('#modal_order_detail_id').val(orderDetailId);
                    $('#acceptOrderModal').modal('show');
                } else {
                    updateOrderStatus(orderId, orderDetailId, selectedStatus, $select);
                }
            });

            $('#acceptOrderForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('orders.setEstimatedDate') }}",
                    method: "POST",
                    data: formData,
                    success: function() {
                        $('#acceptOrderModal').modal('hide');
                        const orderId = $('#modal_order_id').val();
                        const orderDetailId = $('#modal_order_detail_id').val();
                        const selectedStatus = 'accept';
                        const $select = $('select[data-order-detail-id="' + orderDetailId +
                            '"]');

                        updateOrderStatus(orderId, orderDetailId, selectedStatus, $select);
                        showSuccess("Estimated delivery date saved successfully.");
                    },
                    error: function() {
                        showError("Failed to save estimated delivery date.");
                    }
                });
            });

            function updateOrderStatus(orderId, orderDetailId, status, $select) {
                $.ajax({
                    url: "{{ route('order.updateStatus') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        order_detail_id: orderDetailId,
                        order_id: orderId,
                        status: status
                    },
                    success: function(response) {
                        console.log("AJAX success response:", response); // Debug
                        $('#errorMessage').hide();
                        $select.val(response.status);
                        showSuccess(response.message || "Status updated successfully.");
                    },
                    error: function(xhr) {
                        let error = "Something went wrong!";
                        if (xhr.status === 422 && xhr.responseJSON.error) {
                            error = xhr.responseJSON.error;
                        }

                        showError(error);
                        $select.val(previousStatus[orderDetailId]);
                    }
                });
            }

            function showError(message) {
                $('#errorMessage')
                    .text(message)
                    .removeClass('d-none')
                    .show();

                setTimeout(function() {
                    $('#errorMessage').fadeOut(function() {
                        $(this).addClass('d-none');
                    });
                }, 5000);
            }

            function showSuccess(message) {
                $('#ajaxMessage')
                    .text(message)
                    .removeClass('d-none alert-danger')
                    .addClass('alert-success1')
                    .show();

                setTimeout(function() {
                    $('#ajaxMessage').fadeOut(function() {
                        $(this).addClass('d-none').removeClass('alert-success1');
                    });
                }, 5000);
            }
        });
    </script> --}}


    {{-- <script>
        $(document).on('change', 'select[name="status"]', function() {
            let status = $(this).val();
            let orderDetailId = $(this).data('order-detail-id'); // Get order detail ID correctly
            let orderId = $(this).data('order-id');

            $.ajax({
                url: "{{ route('order.updateStatus') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order_detail_id: orderDetailId,
                    order_id: orderId,
                    status: status
                },
                success: function(response) {
                    $("#ajaxMessage")
                        .removeClass("d-none alert-danger")
                        .addClass("alert-success1")
                        .text(response.message)
                        .fadeIn();
                    setTimeout(function() {
                        $("#ajaxMessage").fadeOut();
                    }, 3000);
                },
                error: function() {
                    $("#ajaxMessage")
                        .removeClass("d-none alert-success")
                        .addClass("alert-danger")
                        .text("Something went wrong!")
                        .fadeIn();
                    setTimeout(function() {
                        $("#ajaxMessage").fadeOut();
                    }, 3000);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('select[name="status"]').on('change', function() {
                const selectedStatus = $(this).val();
                const orderId = $(this).data('order-id');
                const orderDetailId = $(this).data('order-detail-id');

                if (selectedStatus === 'accept') {
                    $('#modal_order_id').val(orderId);
                    $('#modal_order_detail_id').val(orderDetailId);
                    $('#acceptOrderModal').modal('show');
                }
            });

            $('#acceptOrderForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('orders.setEstimatedDate') }}", // Update this route accordingly
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        $('#acceptOrderModal').modal('hide');
                        alert('Estimated delivery date saved successfully!');
                        // You can also refresh the page or update DOM if needed
                    },
               
                });
            });
        });
    </script> --}}
@endsection
