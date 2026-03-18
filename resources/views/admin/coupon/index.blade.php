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

                                <h4 class="header-title">Manage Coupon</h4>

                                <a href="{{ route('coupons.create') }}" class="btn btn-primary">Add Coupon</a>

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

                            <!-- Div to show AJAX success/error message -->
                            <div id="ajaxMessage" class="alert d-none alert alert-success1"></div>
                            <div class="dt-responsive">

                                <table id="example" class="table table-bordered" style="width:100%;">

                                    <thead>

                                        <tr>

                                            <th class="sr" data-priority="1">Sr No.</th>
                                            <th>Title</th>
                                            <th>Coupon Code</th>
                                            <th>Description</th>
                                            <th>Discount Type</th>
                                            <th class="status">Status</th>
                                            <th class="action" data-priority="1">Action</th>

                                        </tr>

                                    </thead>

                                    <tbody>
                                        @foreach ($coupon as $key => $coupon_data)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $coupon_data->title ?? '' }}</td>
                                                <td>{{ $coupon_data->coupon_code ?? '' }}</td>
                                                <td>{{ $coupon_data->description ?? '' }}</td>

                                                <td>
                                                    @if (isset($coupon_data->discount_type) && $coupon_data->discount_type == 'flat')
                                                        Flat
                                                    @endif
                                                    @if (isset($coupon_data->discount_type) && $coupon_data->discount_type == 'percentage')
                                                        Percentage
                                                    @endif
                                                </td>


                                                <td>
                                                    <select class="form-control status-dropdown form-select"
                                                        data-id="{{ $coupon_data->id }}"
                                                        onchange="changeStatus(this, 'coupons')">
                                                        <option value="1"
                                                            {{ $coupon_data->status == 1 ? 'selected' : '' }}>
                                                            Active
                                                        </option>
                                                        <option value="0"
                                                            {{ $coupon_data->status == 0 ? 'selected' : '' }}>
                                                            Deactive
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="action-btn">
                                                        <a href="{{ route('coupons.edit', $coupon_data->id) }}"
                                                            class=" btn-sm">
                                                            <i class="fa-regular fa-pen-to-square me-1"></i></a>
                                                        <form action="{{ route('coupons.destroy', $coupon_data->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn" onclick="return confirm('Are you sure you want to delete this coupons?')">
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
@endsection
