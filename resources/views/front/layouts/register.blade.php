<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $meta_title ?? 'Register - AK BEAUTY STORE' }}</title>
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
                            <form id="register-form">
                                <div class="login-logo">
                                    <a href="{{ route('index') }}">
                                        <img src="{{ asset('client_assets/images/logo-2.png') }}" alt="logo">
                                    </a>
                                </div>
                                <h1 class="login-title">Create Account</h1>
                                <p>Enter your details to create an account</p>
                                <div id="register-errors" class="alert alert-danger d-none"></div>
                                <div id="register-success" class="alert alert-success d-none"></div>
                                
                                <!-- Step 1: Registration Form -->
                                <div id="register-step-1">
                                    @if(session('register_email') && session('register_otp_verified'))
                                        <div class="alert alert-success mb-3">
                                            <p>Email verified: <strong>{{ session('register_email') }}</strong></p>
                                        </div>
                                        <input type="hidden" id="email" name="email" value="{{ session('register_email') }}">
                                    @else
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                                            <label for="email">Email address</label>
                                            <span class="text-danger" id="email-error"></span>
                                        </div>
                                    @endif
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" required>
                                        <label for="name">Full Name</label>
                                        <span class="text-danger" id="name-error"></span>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number" maxlength="10" required>
                                        <label for="phone">Phone Number</label>
                                        <span class="text-danger" id="phone-error"></span>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                        <label for="password">Password</label>
                                        <span class="text-danger" id="password-error"></span>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                                        <label for="password_confirmation">Confirm Password</label>
                                        <span class="text-danger" id="password_confirmation-error"></span>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn ak-btn w-100" id="send-otp-btn">Send OTP</button>
                                    </div>
                                </div>

                                <!-- Step 2: OTP Verification -->
                                <div id="register-step-2" style="display: none;">
                                    <div class="alert alert-info">
                                        <p>OTP has been sent to your email. Please check your inbox.</p>
                                    </div>
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
                                    </div>
                                </div>

                                <div class="text-center mt-3">
                                    <p>Already have an account? <a href="{{ route('user.login') }}">Login here</a></p>
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
    // Phone number validation - only numbers
    $('#phone').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });

    // OTP input - only numbers
    $('#otp').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5);
    });

    // Send OTP
    $('#register-form').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#send-otp-btn');
        const originalText = btn.text();
        btn.prop('disabled', true).text('Sending OTP...');
        
        $('#register-errors').addClass('d-none').html('');
        $('.text-danger').text('');
        
        const formData = {
            _token: '{{ csrf_token() }}',
            name: $('#name').val(),
            phone: $('#phone').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val()
        };
        
        // Add email only if not already verified
        @if(!session('register_email') || !session('register_otp_verified'))
            formData.email = $('#email').val();
        @endif
        
        $.ajax({
            url: '{{ route("send.otp") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.code === 200) {
                    $('#register-step-1').hide();
                    $('#register-step-2').show();
                    $('#register-success').removeClass('d-none').html('<p>' + response.message + '</p>');
                    // Make OTP field required when step 2 is shown
                    $('#otp').prop('required', true);
                    // Remove required from step 1 fields
                    $('#name, #phone, #password, #password_confirmation').prop('required', false);
                    @if(!session('register_email') || !session('register_otp_verified'))
                        $('#email').prop('required', false);
                    @endif
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
                    $('#register-errors').removeClass('d-none').html('<p>Something went wrong. Please try again.</p>');
                }
            }
        });
    });

    // Verify OTP
    $('#verify-otp-btn').on('click', function() {
        const btn = $(this);
        const originalText = btn.text();
        btn.prop('disabled', true).text('Verifying...');
        
        $('#otp-error').text('');
        
        $.ajax({
            url: '{{ route("verify.otp") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                otp: $('#otp').val()
            },
            success: function(response) {
                if (response.code === 200) {
                    if (typeof showCartNotification === 'function') {
                        showCartNotification('Registration successful! Redirecting...');
                    }
                    setTimeout(function() {
                        window.location.href = '{{ route("index") }}';
                    }, 1500);
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).text(originalText);
                if (xhr.status === 400) {
                    const errorMsg = xhr.responseJSON.message || 'Invalid OTP';
                    $('#otp-error').text(errorMsg);
                } else {
                    $('#otp-error').text('Something went wrong. Please try again.');
                }
            }
        });
    });

    // Resend OTP
    $('#resend-otp').on('click', function() {
        $('#register-form').submit();
    });
});
</script>
</body>
</html>

