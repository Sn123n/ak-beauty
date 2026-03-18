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
                                <h4 class="header-title">Manage Country</h4>
                                <a href="{{ route('countries.create') }}" class="btn btn-primary">Add Country</a>
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
    
                                            <th>Country Name</th>
    
                                            <th class="status">Status</th>
    
                                            <th class="action" data-priority="2">Action</th>
    
                                        </tr>
    
                                    </thead>
    
                                    <tbody>
                                        {{-- {{ dd($countries) }} --}}
                                        {{-- @foreach ($countrys as $country)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $country->name }}</td>
    
                                                <td>
                                                    <select class="form-select" onchange="changeStatus(this, 'location')" data-id="{{ $country->location_id }}">
                                                        <option value="0" {{ $country->status == 0 ? 'selected' : '' }}>Active</option>
                                                        <option value="1" {{ $country->status == 1 ? 'selected' : '' }}>Deactive</option>
                                                    </select>                                                
                                                </td>
    
                                                <td>
                                                    <div class="action-btn">
                                                        <a href="{{ route('countries.edit', ['country' => $country]) }}"
                                                            class="btn-sm">
        
                                                            <i class="fa-regular fa-pen-to-square me-1"></i>
                                                        </a>
                                                        <form action="{{ route('countries.destroy', ['country' => $country]) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn"
                                                                onclick="return confirm('Are you sure you want to delete this country?')">
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
        function changeStatus(selectElement, page) {
            var id = $(selectElement).data("id");
            var status = $(selectElement).val();

            $.ajax({
                url: "{{ route('updatecountry.status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: status,
                    page: page
                },
                success: function(response) {
                    $("#ajaxMessage").removeClass('d-none').addClass('alert-success')
                        .text(response.message)
                        .fadeIn().delay(2000).fadeOut();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    $("#ajaxMessage").removeClass('d-none').addClass('alert-danger')
                        .text("Error updating status")
                        .fadeIn().delay(2000).fadeOut();
                }
            });
        }


        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 3000);
    </script>
    <script>
       $(document).ready(function() {
        var isResponsive = $(window).width() < 1100;

        $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: isResponsive,
            ajax: {
                url: "{{ route('countries.index') }}",
                type: 'GET',
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name' },
                { data: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            columnDefs: isResponsive ? [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 }
            ] : []
        });
    });        
    </script>
@endsection
