<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AK BEAUTY STORE</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('client_assets/images/fav-logo.png') }}" sizes="32x32" type="image/png">
    <link href="{{ asset('client_assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('client_assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client_assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('client_assets/css/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('client_assets/css/slick-theme.css') }}"/>
    <link rel="stylesheet" href="{{ asset('client_assets/css/fancybox.css') }}" />
    <link rel="stylesheet" href="{{ asset('client_assets/css/photoswipe.css') }}">
    <link rel="stylesheet" href="{{ asset('client_assets/css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client_assets/css/animate.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('client_assets/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('client_assets/css/delay.css') }}">
    <link rel="stylesheet" href="{{ asset('client_assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('client_assets/css/responsive.css') }}">
    <style>
        .cart-icon-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .cart-badge {
            position: absolute;
            top: -1px;
            right: -3px;
            font-size: 10px;
            padding: 0;
            min-width: 18px;
            height: 18px;
            line-height: 18px;
            text-align: center;
            border: 2px solid #fff;
            font-weight: 600;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10;
            background-color: #dc3545 !important;
            color: #fff !important;
            box-sizing: border-box;
        }
        .header-mid-link .cart-icon-link {
            font-size: 20px;
        }
        .header-mid-link .cart-icon-link i {
            position: relative;
        }
    </style>
</head>
<body>
    <header id="site-header">
        <div class="header-top">
            <p>GET FLAT 10% OFF || ON ALL PREPAID ORDERS</p>
        </div>
        <div class="search-box" id="search-box">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="d-flex  align-items-center">
                            <form action="$" class="w-100">
                                <div class="input-group">
                                    <div class="form-floating">
                                        <input type="search" class="form-control" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Search</label>
                                    </div>
                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                            <div class="p-3 pointer" id="close_search">
                                <i class="fa-solid fa-xmark"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar custom-header navbar-expand-lg">
            <div class="container">
                <div class="search d-lg-block d-none pointer">
                    <i class="fa-solid fa-magnifying-glass" id="search-toggle"></i>

                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i> <!-- hamburger icon -->
                    <i class="fa-solid fa-xmark d-none"></i> <!-- close icon -->
                </button>

                <a class="navbar-brand" href="#">
                    <img src="{{ asset('client_assets/images/logo-2.png') }}" alt="">
                </a>
                <div class="header-mid-link">
                    <div class="search d-lg-none d-block">
                        <a href="javscript:void(0);">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </a>
                    </div>
                    @if(Auth::check())
                        <div class="dropdown">
                            <a href="#" class="d-none d-md-flex dropdown-toggle" data-bs-toggle="dropdown" id="userDropdown">
                                <i class="fa-solid fa-user"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a></li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('user.login') }}" class="d-none d-md-flex"><i class="fa-solid fa-user"></i></a>
                    @endif
                    <a href="{{ route('cart.view') }}" class="cart-icon-link">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="cart-badge" id="cart-count-badge" style="display: none;">0</span>
                    </a>
                </div>
            </div>
            <div class="container nav-bottom">
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mx-auto ">
                        <li class="nav-item {{ request()->routeIs('index') ? 'active' : '' }}">
                            <a class="nav-link" aria-current="page" href="{{ route('index') }}">Home</a>
                        </li>
                        @if(isset($navCategories) && $navCategories->count() > 0)
                            @foreach($navCategories as $category)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('products.filter') }}?category_id={{ $category->id }}">{{ $category->name }}</a>
                            </li>
                            @endforeach
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="track-order.php">Track Order</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
