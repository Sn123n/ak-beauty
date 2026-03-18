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

                                <h4 class="header-title">Contact Inquiry</h4>
                                {{-- <a href="{{ route('contactus.create') }}" class="btn btn-primary">Add Contact Inquiry</a> --}}
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
    
                                            <th>Name</th>
    
                                            <th>Email</th>
    
                                            <th>Phone Number</th>
    
                                            <th class="status">Status</th>
    
                                            <th class="action" data-priority="2">Action</th>
    
                                        </tr>
    
                                    </thead>
    
                                    <tbody>
                                        @foreach ($contacts as $contact)
                                            <tr>
    
                                                <th scope="row">{{ $loop->iteration }}</th>
    
                                                <td>{{ $contact->name }}</td>
                                                <td>{{ $contact->email }}</td>
                                                <td>{{ $contact->phone }}</td>
                                                <td>
                                                    <select class="form-control status-dropdown form-select"
                                                        data-id="{{ $contact->id }}"
                                                        onchange="changeStatus(this, 'contactus')">
                                                        <option value="1" {{ $contact->status == 1 ? 'selected' : '' }}>
                                                            Active</option>
                                                        <option value="0" {{ $contact->status == 0 ? 'selected' : '' }}>
                                                            Deactive</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="action-btn">
                                                        <a href="#" class="btn-sm viewUserDetails" data-bs-toggle="modal"
                                                            data-bs-target="#myModal" data-id="{{ $contact->id }}">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <form action="{{ route('contactus.destroy', $contact->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn" onclick="return confirm('Are you sure you want to delete this Contact inquiry?')">
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


    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Contact Inquiry</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="modalUserDetails">
                    Loading...
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    @include('admin.layouts.footer')
    <script>
        $(document).ready(function() {
            $('.viewUserDetails').click(function() {
                var userId = $(this).data('id'); // Fetch user ID from button

                $.ajax({
                    url: "{{ route('contactus.detail') }}",
                    type: 'get',
                    data: {
                        user_id: userId,
                        _token: "{{ csrf_token() }}" // Required for Laravel POST request
                    },
                    success: function(response) {
                        console.log(response);

                        $('#modalUserDetails').html(
                            `<p><strong>Name:</strong> ${response.name}</p>
         <p><strong>Email:</strong> ${response.email}</p>
         <p><strong>Phone Number:</strong> ${response.phone}</p>
         <p><strong>Message:</strong> ${response.message}</p>`
                        );
                    },

                    error: function() {
                        $('#modalUserDetails').html(
                            '<p style="color:red;">Error fetching details.</p>');
                    }
                });
            });
        });
    </script>
    <script>
        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 3000);
    </script>
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
