@extends('admin.layouts.header')

@section('content')
    <div class="content">



        <!-- Start Content-->

        <div class="container-fluid">



            <!-- start page title -->

            <div class="row">

                <div class="col-12">

                    <div class="page-title-box">

                        <div class="page-title-right">

                            <ol class="breadcrumb m-0">

                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>

                                <li class="breadcrumb-item active">Welcome!</li>




                            </ol>

                        </div>

                        <h4 class="page-title">Welcome, {{ Auth::user()->name }}!</h4>

                    </div>

                </div>

            </div>

            <!-- end page title -->

            <div class="dashboard">

                <div class="row">

                    <div class="col-lg-3 col-md-4">

                        <div class="card widget-flat text-bg-white">

                            <div class="card-body">

                                <div class="float-end">

                                    <i class="fa-solid fa-dolly"></i>

                                </div>

                                <h6 class="text-uppercase mt-0">Total Orders</h6>

                                <h2 class="mt-2 mb-0 counter" data-target="0"></h2>

                            </div>

                        </div>

                    </div>

                    <!-- end col-->

                    <div class="col-lg-3 col-md-4">

                        <div class="card widget-flat text-bg-white">

                            <div class="card-body">

                                <div class="float-end">

                                    <!--<i class="fa-solid fa-boxes-packing"></i>-->

                                    <i class="fa-solid fa-truck-ramp-box"></i>

                                </div>

                                <h6 class="text-uppercase mt-0">Completed Orders</h6>

                                <h2 class="mt-2 mb-0 counter" data-target="0"></h2>

                            </div>

                        </div>

                    </div>

                    <!-- end col-->

                    <div class="col-lg-3 col-md-4">

                        <div class="card widget-flat text-bg-white">

                            <div class="card-body">

                                <div class="float-end">

                                    <i class="fa-solid fa-box"></i>

                                </div>

                                <h6 class="text-uppercase mt-0">Total Product</h6>
                                <h2 class="mt-2 mb-0 counter" data-target="{{ $totalProducts ?? 0 }}">0</h2>
                            </div>

                        </div>

                    </div>

                    <!-- end col-->

                    <div class="col-lg-3 col-md-4">

                        <div class="card widget-flat text-bg-white">

                            <div class="card-body">

                                <div class="float-end">

                                    <i class="fa-solid fa-list"></i>

                                </div>

                                <h6 class="text-uppercase mt-0">Total Category</h6>

                                <h2 class="mt-2 mb-0 counter" data-target="{{ $category ?? 0 }}">0</h2>

                            </div>

                        </div>

                    </div>

                    <!-- end col-->

                    <div class="col-lg-3 col-md-4">

                        <div class="card widget-flat text-bg-white">

                            <div class="card-body">

                                <div class="float-end">

                                    <i class="fa-solid fa-boxes-stacked"></i>

                                </div>

                                <h6 class="text-uppercase mt-0">Current Month Registration</h6>

                                <h2 class="mt-2 mb-0 counter" data-target="{{ $totalUsersThisMonth ?? 0 }}">0</h2>

                            </div>

                        </div>

                    </div>


                    <!-- end col-->

                    {{-- <div class="col-lg-3 col-md-4">

                        <div class="card widget-flat text-bg-white">

                            <div class="card-body">

                                <div class="float-end">

                                    <i class="fa-solid fa-newspaper"></i>

                                </div>

                                <h6 class="text-uppercase mt-0">Total advertise of Current Year</h6>

                                <h2 class="mt-2 mb-0 counter" data-target="0"></h2>

                            </div>

                        </div>

                    </div> --}}

                    <!-- end col-->

                    {{-- <div class="col-lg-3 col-md-4">

                        <div class="card widget-flat text-bg-white">

                            <div class="card-body">

                                <div class="float-end">

                                    <i class="fa-solid fa-scroll"></i>

                                </div>

                                <h6 class="text-uppercase mt-0">Total advertise</h6>

                                <h2 class="mt-2 mb-0 counter" data-target="0"></h2>

                            </div>

                        </div>

                    </div> --}}

                    <!-- end col-->

                </div>

            </div>



        </div>

        <!-- container -->



    </div>

    <!-- content -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const counters = document.querySelectorAll(".counter");

            counters.forEach((counter) => {
                counter.innerText = "0";
                const target = +counter.getAttribute("data-target");

                if (target > 0) { // Ensure counter runs only when target > 0
                    const updateCounter = () => {
                        const c = +counter.innerText;
                        const increment = target / 200;

                        if (c < target) {
                            counter.innerText = `${Math.ceil(c + increment)}`;
                            setTimeout(updateCounter, 5);
                        } else {
                            counter.innerText = target;
                        }
                    };

                    updateCounter();
                }
            });
        });
    </script>

    @include('admin.layouts.footer')
@endsection
