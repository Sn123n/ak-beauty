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

                                <h4 class="header-title">Create DiscountText</h4>

                                <a href="{{ route('discount-text.index') }}" class="btn btn-primary">Manage DiscountText</a>

                            </div>

                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('discount-text.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-lg-6 col-md-6">

                                        <div class="mb-3">

                                            <label for="name" class="form-label">Title</label>

                                            <input type="text" id="title" name="title" class="form-control">
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status1" name="status" class="form-control form-select">
                                                <option value="1">Active</option>
                                                <option value="0">Deactive</option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">

                                        <div class="">

                                            <button type="submit" class="btn btn-primary">Submit</button>

                                        </div>

                                    </div>

                                </div> <!-- end row-->

                            </form>



                        </div> <!-- end card-body -->

                    </div> <!-- end card -->

                </div><!-- end col -->

            </div><!-- end row -->





        </div> <!-- container -->



    </div> <!-- content -->

    @include('admin.layouts.footer')

@endsection
