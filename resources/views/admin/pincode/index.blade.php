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
                                <h4 class="header-title">Manage Pincode</h4>
                                <a href="{{ route('pincode.create') }}" class="btn btn-primary">Add Pincode</a>
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
    
                                            <th class="sr" data-priority="1">Sr</th>
    
                                            <th>Pincode</th>
    
                                            <th>City</th>
    
                                            <th>State</th>
    
                                            <th>Price</th>                                                                 
    
                                            <th class="action" data-priority="2">Action</th>
    
                                        </tr>
    
                                    </thead>
    
                                    <tbody>
                                        {{-- {{ dd($countries) }} --}}
                                        {{-- @foreach ($cities as $city)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $city->name }}</td>
                                                <td>{{ $city->parent ? $city->parent->name : 'N/A' }}</td>
                                                <td>{{ $city->parent && $city->parent->parent ? $city->parent->parent->name : 'N/A' }}
                                                </td>
                                                <td>
                                                    <select class="form-select" onchange="changeStatus(this, 'location')"
                                                        data-id="{{ $city->location_id }}">
                                                        <option value="0" {{ $city->status == 0 ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="1" {{ $city->status == 1 ? 'selected' : '' }}>
                                                            Deactive</option>
                                                    </select>
                                                </td>
    
                                                <td>
                                                    <div class="action-btn">
                                                        <a href="{{ route('cities.edit', ['city' => $city]) }}" class="btn-sm">
        
                                                            <i class="fa-regular fa-pen-to-square me-1"></i>
                                                        </a>
                                                        <form action="{{ route('cities.destroy', ['city' => $city]) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn"
                                                                onclick="return confirm('Are you sure you want to delete this city?')">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach --}}
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
            var isResponsive = $(window).width() < 1100;

            $('#example').DataTable({
                processing: true,
                serverSide: true,
                responsive: isResponsive,
                ajax: {
                    url: "{{ route('pincode.index') }}",
                    type: 'GET',
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'pincode' },
                    { data: 'city' },
                    { data: 'state' },
                    { data: 'price' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                columnDefs: isResponsive ? [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 }
                ] : []
            });
        });

    </script>

{{--     
    <script>
        new DataTable('#example', {

            responsive: true, // Enables responsiveness overall

            breakpoints: [

                {
                    name: 'tablet',
                    width: 1024
                },

                {
                    name: 'fablet',
                    width: 768
                },

                {
                    name: 'phone',
                    width: 480
                }

            ]

        });
    </script> --}}
@endsection
