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
                        <div class="dt-responsive"></div>
                        <table id="example" class="table table-bordered" style="width:100%;">
                            <thead>
                                <tr>
                                    <th data-priority="1" >Sr</th>
                                    <th class="table-img">Image</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th data-priority="2" >Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><img src="{{asset('assets/images/bg-profile.jpg')}}" alt="image" class="table-img" ></td>
                                    <td>Lorem Ipsum</td>
                                    <td>321</td>
                                    <td>2</td>
                                    <td>18/12/2024</td>
                                    <td>Pending</td>
                                    <td>
                                        <i class="fa-regular fa-pen-to-square me-1"></i>
                                        <i class="fa-solid fa-trash-can"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

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