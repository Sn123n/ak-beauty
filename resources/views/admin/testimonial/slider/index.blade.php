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

                                <h4 class="header-title">Manage Sliders</h4>

                                <a href="{{ route('sliders.create') }}" class="btn btn-primary">Add Sliders</a>

                            </div>

                        </div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success1" id="successMessage">
                                    {{ session('success') }}
                                </div>

                            @endif


                            <div class="dt-responsive">

                                <table id="example" class="table table-bordered" style="width:100%;">

                                    <thead>

                                        <tr>

                                            <th>Sr</th>

                                            <th>Name</th>

                                            <th>Slider Image</th>

                                            <th>Action</th>

                                        </tr>

                                    </thead>

                                    <tbody>
                                        @foreach ($sliders as $slider)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>

                                                <td>{{ $slider->name }}</td>

                                                <td>
                                                    @if ($slider->image)
                                                        <img src="{{ asset('slider/' . $slider->image) }}" width="100"
                                                            alt="slider Image">
                                                    @else
                                                        No image
                                                    @endif
                                                </td>

                                                {{-- <td>{{ $slider->content }}</td>  --}}
                                                <td>
                                                    <a href="{{ route('sliders.edit', $slider->id) }}" class=" btn-sm"> <i
                                                            class="fa-regular fa-pen-to-square me-1"></i></a>
                                                    <form action="{{ route('sliders.destroy', $slider->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class=""onclick="return confirm('Are you sure you want to delete this slider?')"
                                                            style="color: rgb(32, 2, 2);border: none">
                                                            <i class="fa-solid fa-trash-can"></i>

                                                        </button>
                                                    </form>
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


    <script>
        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 3000); // 3000 milliseconds = 3 seconds
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

    @include('admin.layouts.footer')
@endsection
