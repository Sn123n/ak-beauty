@include('front.dashboard.header')
    <div class="main dashboard">
        <section class="">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="sec-title text-start">
                            <h3 class="section-main-title">
                                Settings
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="logout">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="sign-title">
                                <h6><i class="fa-solid fa-lock"></i> Sign out everywhere</h6>
                            </div>
                            <p>If you're lost a device or have security concerns, log out everywhere  to ensure the security of your account.</p>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="sign-out">
                                        <div>
                                            <button class="btn ak-btn">Sign out everywhere</button>
                                        </div>
                                        <p class="mb-0">You'll also be signed out on this device</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('front.dashboard.footer')
