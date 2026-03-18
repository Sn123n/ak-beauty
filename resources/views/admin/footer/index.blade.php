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
                                <h4 class="header-title">Manage Footer Icon</h4>

                                <a href="{{ route('footer-icon.create') }}" class="btn btn-primary">Add FooterIcon</a>

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

                                            <th>Image</th>

                                            <th>Title</th>

                                            <th>Detail</th>

                                            <th>Status</th>

                                            <th class="action">Action</th>

                                        </tr>

                                    </thead>

                                    <tbody>
                                        @foreach ($footers as $footer)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>

                                                <td>
                                                    @if ($footer->image)
                                                        <img src="{{ asset('footericon/' . $footer->image) }}"
                                                            width="100" alt="footer Image">
                                                    @else
                                                        No image
                                                    @endif
                                                </td>

                                                <td>{{ $footer->title }}</td>
                                                <td>{{ $footer->detail }}</td>
                                                <td>
                                                    <select class="form-control status-dropdown form-select"
                                                        data-id="{{ $footer->id }}"
                                                        onchange="changeStatus(this, 'footer-icon')">
                                                        <option value="1" {{ $footer->status == 1 ? 'selected' : '' }}>
                                                            Active
                                                        </option>
                                                        <option value="0" {{ $footer->status == 0 ? 'selected' : '' }}>
                                                            Deactive
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="action-btn">
                                                        <a href="{{ route('footer-icon.edit', $footer->id) }}"
                                                            class=" btn-sm"> <i
                                                                class="fa-regular fa-pen-to-square me-1"></i></a>
                                                        <form action="{{ route('footer-icon.destroy', $footer->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn"
                                                                onclick="return confirm('Are you sure you want to delete this footer?')">
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
