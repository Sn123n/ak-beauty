@php
    use App\Models\User;
    $data = User::where('id', 1)->first();
    $image = $data->image ?? '';
    $name = $data->name ?? '';
@endphp

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8" />

    <title>AK BEAUTY STORE</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <!-- App favicon -->

    <link rel="shortcut icon" href="{{ asset('client_assets/images/fav-logo.png') }}">

    <!-- Theme Config Js -->

    <script src="{{ asset('assets/js/config.js') }}"></script>

    <!-- App css -->

    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->

    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom css -->

    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />

    <!-- All css -->

    <link href="{{ asset('assets/css/all.css') }}" rel="stylesheet" type="text/css" />

    <!-- Responsive css -->

    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />



    <!-- Datatables css -->

    <link href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/css/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Datepicker css -->

    <link href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css" />



</head>



<body>

    <!-- Begin page -->

    <div class="wrapper">



        <!-- ========== Topbar Start ========== -->

        <div class="navbar-custom">

            <div class="topbar container-fluid">

                <div class="d-flex align-items-center gap-1">



                    <!-- Topbar Brand Logo -->

                    <div class="logo-topbar">



                        <!-- Logo Dark -->

                        <a href="{{ route('dashboard') }}" class="logo-dark">

                            <span class="logo-lg">

                                <img src="{{ asset('assets/images/logo.png') }}" alt="dark logo">

                            </span>

                            <span class="logo-sm">

                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo">

                            </span>

                        </a>

                    </div>



                    <!-- Sidebar Menu Toggle Button -->

                    <button class="button-toggle-menu">

                        <i class="fa-solid fa-bars"></i>

                        <i class="fa-solid fa-arrow-right"></i>

                    </button>



                    <!-- Horizontal Menu Toggle Button -->

                    <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">

                        <div class="lines">

                            <span></span>

                            <span></span>

                            <span></span>

                        </div>

                    </button>



                    <!-- Topbar Search Form -->

                </div>



                <ul class="topbar-menu d-flex align-items-center gap-3">

                    @php
                        $notifications = getAdminNotifications();
                    @endphp

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ri-notification-3-line fs-22"></i>
                            <span class="noti-icon-badge badge text-bg-dark">{{ count($notifications) }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                            <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold"> Notification</h6>
                                    </div>
                                    <div class="col-auto">
                                        {{-- <a href="javascript:void(0);"
                        class="text-dark text-decoration-underline"><small>Clear All</small></a> --}}
                                    </div>
                                </div>
                            </div>

                            <div style="max-height: 300px;" data-simplebar>
                                @if (count($notifications) > 0)
                                    @foreach ($notifications as $notify)
                                        <a href="{{ route('notifications.mark', ['id' => $notify['id']]) }}"
                                            class="dropdown-item notify-item">
                                            <div class="notify-icon bg-light">
                                                <i class="mdi {{ $notify['icon'] }} {{ $notify['color'] }}"></i>
                                            </div>
                                            <p class="notify-details">
                                                {{ $notify['message'] }}
                                                <small class="noti-time">{{ $notify['time'] }}</small>
                                            </p>
                                        </a>
                                    @endforeach
                                @else
                                    <p class="dropdown-item text-center">No new notifications</p>
                                @endif
                            </div>
                            <a href="{{ route('notifications.viewAll') }}"
                                class="dropdown-item text-center text-primary text-decoration-underline fw-bold notify-item border-top border-light py-2">
                                View All
                            </a>
                        </div>
                    </li>

                    <li class="dropdown">

                        <a class="nav-link dropdown-toggle arrow-none nav-user" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">

                            <span class="account-user-avatar">

                                <img src="{{ asset('profile/' . $image) }}" alt="user-image" width="32"
                                    class="rounded-circle">

                            </span>

                            <span class="d-lg-block d-none">

                                <h5 class="my-0 fw-normal">{{ $name }} <i
                                        class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i></h5>

                            </span>

                        </a>

                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">

                            <!-- item-->

                            <div class=" dropdown-header noti-title">

                                <h6 class="text-overflow m-0">Welcome !</h6>

                            </div>



                            <!-- item-->

                            <a href="{{ route('edit.profile') }}" class="dropdown-item">

                                <i class="ri-account-circle-line fs-18 align-middle me-1"></i>

                                <span>My Account</span>

                            </a>



                            <!-- item-->

                            <a href="{{ route('admin.logout') }}" class="dropdown-item text-danger">

                                <i class="ri-logout-box-line fs-18 align-middle me-1"></i>

                                <span>Logout</span>

                            </a>

                        </div>

                    </li>

                </ul>

            </div>

        </div>

        <!-- ========== Topbar End ========== -->





        <!-- ========== Left Sidebar Start ========== -->

        <div class="leftside-menu">



            <!-- Brand Logo Light -->

            <a href="{{ route('dashboard') }}" class="logo logo-light">

                <span class="logo-lg">

                    <img src="{{ asset('client_assets/images/logo-2.png') }}" alt="logo">

                </span>

                <span class="logo-sm">

                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="small logo">

                </span>

            </a>



            <!-- Brand Logo Dark -->

            <a href="dashboard.php" class="logo logo-dark">

                <span class="logo-lg">

                    <img src="{{ asset('client_assets/images/logo-2.png') }}" alt="dark logo">

                </span>

                <span class="logo-sm">

                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="small logo">

                </span>

            </a>



            @include('admin.layouts.sidebar')

        </div>




    <!--content div start-->

    <div class="content-page">

        @yield('content')
