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

                                <h4 class="header-title">Order Listing</h4>

                            </div>

                        </div>

                        <div class="card-body">
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
                            <div id="ajaxMessage" class="alert d-none"></div>

                            <div class="dt-responsive">
                                <table id="example" class="table table-bordered" style="width:100%;">

                                    <thead>
                                        <tr>
                                            <th class="sr" data-priority="1">Sr</th>
                                            <th>Order Id</th>
                                            <th>Total Amount</th>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            <th>Mobile Number</th>
                                            <th>Date</th>
                                            <th class="action" data-priority="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order_history as $key => $order)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $order->order_id ?? '-' }}</td>
                                                <td>{{ $order->total_amount ?? '-' }}</td>
                                                <td>{{ $order->user->name ?? '-' }}</td>
                                                <td>{{ $order->user->email ?? '-' }}</td>
                                                <td>{{ $order->user->phone ?? '-' }}</td>
                                                {{-- <td>{{ $order->userAddress->address ?? '-' }}</td> --}}
                                                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                                <td>
                                                    <div class="action-btn">
                                                        <a href="{{ route('view.order', $order->id) }}">
                                                            <i class="fa-regular fa-eye me-1"></i>
                                                        </a>
                                                        <form action="{{ route('order.delete', $order->id) }}" method="POST"
                                                            style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn"
                                                                onclick="return confirm('Are you sure you want to delete this order?')">
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
    </div> <!-- content -->

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
        $(document).on('change', 'select[name="status"]', function() {
            let status = $(this).val();
            let orderId = $(this).data('order-id');
            let orderDetailId = $(this).data('order-detail-id');

            console.log("Order ID:", orderId, "Order Detail ID:", orderDetailId, "Status:", status);

            $.ajax({
                url: "{{ route('order.updateStatus') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order_id: orderId,
                    order_detail_id: orderDetailId,
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
                error: function(xhr) {
                    console.log(xhr.responseText);
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
@endsection
