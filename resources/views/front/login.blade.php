<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $meta_title ?? 'Login - AK BEAUTY STORE' }}</title>
    <meta name="keywords" content="{{ $meta_keywords ?? '' }}">
    <meta name="description" content="{{ $meta_description ?? '' }}">
    <link rel="icon" href="{{ asset('client_assets/images/fav-logo.png') }}" sizes="32x32" type="image/png">
    <link href="{{ asset('client_assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('client_assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client_assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('client_assets/css/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('client_assets/css/slick-theme.css') }}"/>
    <link rel="stylesheet" href="{{ asset('client_assets/css/fancybox.css') }}" />
    <link rel="stylesheet" href="{{ asset('client_assets/css/photoswipe.css') }}">
    <link rel="stylesheet" href="{{ asset('client_assets/css/animate.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('client_assets/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('client_assets/css/delay.css') }}">
    <link rel="stylesheet" href="{{ asset('client_assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('client_assets/css/responsive.css') }}">
</head>
<body class="login-body">
<div class="main">
    <div class="login">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form id="login-form">
                                <div class="login-logo">
                                    <a href="{{ route('index') }}">
                                        <img src="{{ asset('client_assets/images/logo-2.png') }}" alt="logo">
                                    </a>
                                </div>
                                <h1 class="login-title">Sign in</h1>
                                <p>Enter your email and password to sign in</p>
                                <div id="login-errors" class="alert alert-danger d-none"></div>
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                                    <label for="email">Email address</label>
                                    <span class="text-danger" id="email-error"></span>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                    <label for="password">Password</label>
                                    <span class="text-danger" id="password-error"></span>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <div>
                                    <button type="submit" class="btn ak-btn w-100" id="login-btn">Sign in</button>
                                </div>
                                <div class="text-center mt-3">
                                    <p>Don't have an account? <a href="{{ route('user.register') }}">Register here</a></p>
                                    <p><a href="{{ route('forgot-password') }}">Forgot Password?</a></p>
                                </div>
                                <div class="log-link">
                                    <a href="javascript:void(0);">Privacy policy</a>
                                    <a href="javascript:void(0);">Terms of service</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('client_assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('client_assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('client_assets/js/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('client_assets/js/slick.min.js') }}"></script>
<script src="{{ asset('client_assets/js/fancybox.umd.js') }}"></script>
<script src="{{ asset('client_assets/js/wow.min.js') }}"></script>
<script src="{{ asset('client_assets/js/custom.js') }}"></script>
<script>
$(document).ready(function() {
    $('#login-form').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#login-btn');
        const originalText = btn.text();
        btn.prop('disabled', true).text('Signing in...');
        
        $('#login-errors').addClass('d-none').html('');
        $('.text-danger').text('');
        
        $.ajax({
            url: '{{ route("check_login") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                email: $('#email').val(),
                password: $('#password').val(),
                remember: $('#remember').is(':checked')
            },
            success: function(response) {
                if (response.code === 200) {
                    window.location.href = response.redirect_url || '{{ route("index") }}';
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).text(originalText);
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key + '-error').text(value[0]);
                    });
                } else if (xhr.status === 401 || xhr.status === 403) {
                    const errorMsg = xhr.responseJSON.errors?.invalid?.[0] || 'Invalid email or password';
                    $('#login-errors').removeClass('d-none').html('<p>' + errorMsg + '</p>');
                } else {
                    $('#login-errors').removeClass('d-none').html('<p>Something went wrong. Please try again.</p>');
                }
            }
        });
    });
});
</script>
</body>
</html>
