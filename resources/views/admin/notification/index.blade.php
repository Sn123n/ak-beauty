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

                                <h4 class="header-title">Notification</h4>

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
                                            <th class="table-img">Type</th>
                                            <th>User Name</th>                                       
                                            <th>User Email</th>
                                            <th>Date</th>
                                            <th class="action" data-priority="2">Action</th>
                                        </tr>
                                    </thead>
    
                                    <tbody>
                                        @foreach ($nots as $key => $nots)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>                                                                                    
                                                <td>{{ $nots->type ?? '-' }}</td>
                                                <td> 
                                                    {{ $nots->order->user->name 
                                                        ?? ($nots->review->name 
                                                        ?? ($nots->user->name ?? '-')) }}
                                                </td>
                                                <td> 
                                                    {{ $nots->order->user->email 
                                                        ?? ($nots->review->email 
                                                        ?? ($nots->user->email ?? '-')) }}
                                                </td>
                                                
                                                <td>{{ $nots->created_at ? $nots->created_at->format('d-m-Y') : '-' }}</td>
                                                <td>
                                                    <div class="action-btn">
                                                        {{-- <a href="{{ route('product.detail', $nots->product->id) }}">
                                                            <i class="fa-regular fa-eye me-1"></i>
                                                        </a> --}}
                                                        <form action="{{route('notification_remove', $nots->id)}}" method="POST"
                                                            style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn"
                                                                onclick="return confirm('Are you sure you want to delete this notification?')">
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
        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 3000);
    </script>
@endsection
