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
                                
                                <!-- Step 1: Email -->
                                <div id="login-step-1">
                                    <p>Enter your email and we'll send you a verification code</p>
                                    <div id="login-errors" class="alert alert-danger d-none"></div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                                        <label for="email">Email address</label>
                                        <span class="text-danger" id="email-error"></span>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn ak-btn w-100" id="send-otp-btn">Continue</button>
                                    </div>
                                </div>

                                <!-- Step 2: OTP Verification -->
                                <div id="login-step-2" style="display: none;">
                                    <p>Enter the verification code sent to <strong id="email-display"></strong></p>
                                    <div id="otp-errors" class="alert alert-danger d-none"></div>
                                    <div id="otp-success" class="alert alert-success d-none"></div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" maxlength="5">
                                        <label for="otp">Enter OTP</label>
                                        <span class="text-danger" id="otp-error"></span>
                                    </div>
                                    <div>
                                        <button type="button" class="btn ak-btn w-100" id="verify-otp-btn">Verify OTP</button>
                                    </div>
                                    <div class="text-center mt-3">
                                        <p>Didn't receive OTP? <a href="javascript:void(0);" id="resend-otp">Resend OTP</a></p>
                                        <p><a href="javascript:void(0);" id="back-to-email">Change Email</a></p>
                                    </div>
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
    // OTP input - only numbers
    $('#otp').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5);
    });

    // Step 1: Send OTP
    $('#login-form').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#send-otp-btn');
        const originalText = btn.text();
        btn.prop('disabled', true).text('Sending OTP...');
        
        $('#login-errors').addClass('d-none').html('');
        $('#email-error').text('');
        
        $.ajax({
            url: '{{ route("send.login.otp") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                email: $('#email').val()
            },
            success: function(response) {
                if (response.code === 200) {
                    $('#login-step-1').hide();
                    $('#login-step-2').show();
                    $('#email-display').text($('#email').val());
                    $('#otp-success').removeClass('d-none').html('<p>' + response.message + '</p>');
                    // Make OTP field required when step 2 is shown
                    $('#otp').prop('required', true);
                    // Remove required from email field
                    $('#email').prop('required', false);
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).text(originalText);
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key + '-error').text(value[0]);
                    });
                } else {
                    const errorMsg = xhr.responseJSON?.message || 'Something went wrong. Please try again.';
                    $('#login-errors').removeClass('d-none').html('<p>' + errorMsg + '</p>');
                }
            }
        });
    });

    // Step 2: Verify OTP
    $('#verify-otp-btn').on('click', function() {
        const btn = $(this);
        const originalText = btn.text();
        btn.prop('disabled', true).text('Verifying...');
        
        $('#otp-errors').addClass('d-none').html('');
        $('#otp-error').text('');
        
        $.ajax({
            url: '{{ route("verify.login.otp") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                otp: $('#otp').val()
            },
            success: function(response) {
                if (response.code === 200) {
                    // User exists - login successful
                    if (typeof showCartNotification === 'function') {
                        showCartNotification('Login successful!');
                    }
                    setTimeout(function() {
                        window.location.href = response.redirect_url || '{{ route("index") }}';
                    }, 1000);
                } else if (response.code === 201) {
                    // User doesn't exist - redirect to register
                    if (typeof showCartNotification === 'function') {
                        showCartNotification('OTP verified! Please complete registration.');
                    }
                    setTimeout(function() {
                        window.location.href = response.redirect_url || '{{ route("user.register") }}';
                    }, 1500);
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).text(originalText);
                if (xhr.status === 400) {
                    const errorMsg = xhr.responseJSON.message || 'Invalid OTP';
                    $('#otp-error').text(errorMsg);
                } else if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key + '-error').text(value[0]);
                    });
                } else {
                    $('#otp-errors').removeClass('d-none').html('<p>Something went wrong. Please try again.</p>');
                }
            }
        });
    });

    // Resend OTP
    $('#resend-otp').on('click', function() {
        $('#login-form').submit();
    });

    // Back to email step
    $('#back-to-email').on('click', function() {
        $('#login-step-2').hide();
        $('#login-step-1').show();
        $('#otp').val('').prop('required', false);
        $('#email').prop('required', true);
        $('#otp-errors').addClass('d-none').html('');
        $('#otp-success').addClass('d-none').html('');
    });
});
</script>
</body>
</html>

