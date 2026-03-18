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

                                <h4 class="header-title">Manage DiscountText</h4>

                                <a href="{{ route('discount-text.create') }}" class="btn btn-primary">Add DiscountText</a>

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
    
                                            <th class="sr">Sr</th>
    
                                            <th>Title</th>
    
                                            <th class="status">Status</th>
    
                                            <th class="action">Action</th>
    
                                        </tr>
    
                                    </thead>
    
                                    <tbody>
                                        @foreach ($texts as $text)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
    
                                                <td>{{ $text->title }}</td>
    
                                                <td>
                                                    <select class="form-control status-dropdown form-select"
                                                        data-id="{{ $text->id }}"
                                                        onchange="changeStatus(this, 'discount-text')">
                                                        <option value="1"
                                                            {{ $text->status == 1 ? 'selected' : '' }}>Active</option>
                                                        <option value="0"
                                                            {{ $text->status == 0 ? 'selected' : '' }}>Deactive</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="action-btn">
                                                        <a href="{{ route('discount-text.edit', $text->id) }}"
                                                            class=" btn-sm"> <i class="fa-regular fa-pen-to-square me-1"></i></a>
                                                        <form action="{{ route('discount-text.destroy', $text->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn" onclick="return confirm('Are you sure you want to delete this text?')"
                                                                >
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
        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 3000);
    </script>
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
    </script>
@endsection
