<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AK BEAUTY STORE</title>
    <link rel="icon" href="assets/images/fav-logo.png" sizes="32x32" type="image/png">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/photoswipe.css">
    <link rel="stylesheet" href="assets/css/animate.min.css" />
    <link rel="stylesheet" href="assets/css/all.css">
    <link rel="stylesheet" href="assets/css/delay.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>

<body>
    <header class="py-4 border-bottom dashboard-header">
        <div class="container d-flex align-items-center justify-content-between">
            <!-- Left Section: Logo & Hamburger -->
            <div class="d-flex align-items-center gap-3">
                <!-- Hamburger Icon -->
               <button class=" d-md-none border-0 bg-transparent " id="menuToggle">
                    <i class="fa-solid fa-bars fs-4" id="menuOpenIcon"></i>
                    <i class="fa-solid fa-xmark fs-4 d-none" id="menuCloseIcon"></i>
                </button>


                <!-- Logo -->
                <a class="navbar-brand" href="#">
                    <img src="assets/images/logo-2.png" alt="THR3E STROKES Logo" class="logo">
                </a>

                <!-- Desktop Navigation -->
                <nav class="nav d-none d-md-flex">
                    <a href="{{route('index')}}" class="nav-link px-3 text-dark">Shop</a>
                    <a href="order.php" class="nav-link px-3 text-dark">Orders</a>
                </nav>
            </div>

            <!-- User dropdown (desktop only) -->
            <div class="dropdown d-none d-md-block">
                <a href="#" class="d-flex align-items-center text-secondary text-decoration-none" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar bg-secondary text-white rounded-circle d-flex justify-content-center align-items-center" style="width:30px; height:30px;">AK</div>
                    <i class="fa-solid fa-chevron-down ms-1 small text-dark"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="userMenu">
                    <li class="px-3 py-2">
                        <div>
                            <i class="fa-regular fa-circle-user text-secondary fs-4"></i>
                            <p class="m-0 small">akcosmetic123@gmail.com</p>
                        </div>
                    </li>
                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                    <li><a class="dropdown-item" href="setting.php">Settings</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.logout') }}">Sign out</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Mobile Side Menu -->
    <div id="mobileMenu" class="mobile-menu">

        <div class="user-info mt-3 mb-4">
            <div class="d-flex align-items-center gap-2">
                <div class="user-avatar bg-secondary text-white rounded-circle d-flex justify-content-center align-items-center" style="width:30px; height:30px;">SV</div>
                <div>
                    <p class="mb-0 ">AK Beauty Store</p>
                    <small>akcosmetic123@gmail.com</small>
                </div>
            </div>
        </div>
        <hr>

        <ul class="list-unstyled">
            <li><a href="index.php" class="menu-link">Shop</a></li>
            <li><a href="order.php" class="menu-link">Orders</a></li>
        </ul>

        <hr>

        <ul class="list-unstyled">
            <li><a href="profile.php" class="menu-link">Profile</a></li>
            <li><a href="setting.php" class="menu-link">Settings</a></li>
            <li><a href="{{ route('user.logout') }}" class="menu-link">Sign out</a></li>
        </ul>
    </div>
