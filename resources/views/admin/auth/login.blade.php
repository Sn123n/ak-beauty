<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8" />

    <title>Rizester</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <!-- App favicon -->

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Theme Config Js -->

    <script src="{{ asset('assets/js/config.js') }}"></script>

    <!-- App css -->

    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style">

    <!-- Icons css -->

    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom css -->

    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css">

</head>



<body class="authentication-bg position-relative">

    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-xxl-5 col-lg-5">

                    <div class="card overflow-hidden">

                        <div class="card-body">

                            <div class="d-flex flex-column h-100">

                                <div class="auth-brand p-4">

                                    <a href="login.php" class="logo-dark text-center">

                                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="dark logo"
                                            height="22">

                                    </a>

                                </div>

                                <div class="px-4 pb-4 my-auto">

                                    @if (session('success'))
                                        <div class="alert alert-success1" id="successMessage">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <!-- form -->

                                    <form action="{{ URL::to('backpanel/checklogin') }}" method="POST">
                                        @csrf
                                        @if ($errors->has('invalid'))
                                            <div class="alert alert-danger mt-3">
                                                {{ $errors->first('invalid') }}
                                            </div>
                                        @endif
                                        <div class="mb-3">

                                            <label for="emailaddress" class="form-label">Email</label>

                                            <input class="form-control" type="email" name="email" id="emailaddress"
                                                value="{{ old('email') }}" placeholder="Enter your email">
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">

                                            <label for="password" class="form-label">Password</label>

                                            <input class="form-control" type="password" name="password" id="password"
                                                placeholder="Enter your password">
                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-0 text-start">

                                            <button class="btn btn-soft-primary w-100" type="submit">

                                                <i class="ri-login-circle-fill me-1"></i> <span class="fw-bold">Log
                                                    In</span> </button>

                                        </div>

                                    </form>

                                    <!-- end form-->

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- end row -->

            </div>

        </div>

        <!-- end container -->

    </div>

    <!-- end page -->



    <!-- Vendor js -->

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

    <!-- App js -->

    <script src="{{ asset('assets/js/app.min.js') }}"></script>

<script>
     setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 3000);
</script>

</body>

</html>
