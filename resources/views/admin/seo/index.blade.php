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

                                <h4 class="header-title">Manage SEO</h4>

                                <a href="{{ route('seo.create') }}" class="btn btn-primary">Add SEO</a>

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
    
                                            <th class="action" data-priority="1">Sr</th>
    
                                            <th>Page Name</th>
    
                                            <th>Meta Title</th>
    
                                            <th>Meta Description</th>
    
                                            <th>Meta Keywords</th>
    
                                            <th class="action" data-priority="2">Action</th>
    
                                        </tr>
    
                                    </thead>
    
                                    <tbody>
                                        @foreach ($seos as $seo)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <th>{{ $seo->page_name }}</th>
                                                <td>{{ $seo->meta_title }}</td>                
                                                <td>{{ strip_tags($seo->meta_description) }}</td>
                                                <td>{{ $seo->meta_keywords }}</td>
                                                                
                                                <td>
                                                    <div class="action-btn">
                                                        <a href="{{ route('seo.edit', $seo->id) }}" class=" btn-sm"> <i
                                                                class="fa-regular fa-pen-to-square me-1"></i></a>
                                                        <form action="{{ route('seo.destroy', $seo->id) }}" method="POST"
                                                            style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn" onclick="return confirm('Are you sure you want to delete this seo?')">
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
