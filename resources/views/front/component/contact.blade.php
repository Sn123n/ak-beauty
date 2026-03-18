@include('front.layouts.header')
<div class="main">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-10 mx-auto">
                    <div class="sec-title">
                        <h3 class="section-main-title text-start">
                            Contact Us
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <form action="#" class="contact-form">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mail-address">
                                    <p>Official email address: akbeautyshop@gmail.com</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="address">
                                    <p>Business address</p>
                                    <p>207,2st floor, plot no 64,paleja house, 400003 MUMBAI Maharashtrs, India</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="name" placeholder="Name">
                                    <label for="name">Name</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="mail" placeholder="Email">
                                    <label for="mail">Email address</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-floating mb-3">
                                    <input type="tel" class="form-control" id="p_number" placeholder="Phone Number">
                                    <label for="p_number">Phone Number</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-floating mb-3">
                                    <textarea name="" id="comment" placeholder="comment" rows="10" class="form-control text-area" ></textarea>
                                    <label for="comment">Comment</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mt-3">
                                    <button type="submit" class="btn ak-btn">Send</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@include('front.layouts.footer')
