@include('front.dashboard.header')
<div class="main dashboard">
    <section class="order-details-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="sec-title text-start d-flex gap-3 ">
                        <a href="order.php"> <i class="fa-solid fa-arrow-left text-dark"></i></a>
                        <h3 class="section-main-title mt-0">
                            Orders #TS31377 <br>
                            <small class="block w-100">Confirmed Oct 12</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 d-none d-md-block">
                    <div class="d-flex justify-content-end">
                        <a href="javascript:void(0);" class="btn ak-outline-btn bg-white">Buy again</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 order-2 order-lg-1">
                    <div class="card mt-4 mt-lg-0">
                        <div class="card-body">
                            <div class="order-status d-flex align-items-center justify-content-between">
                                <div class="status">
                                    <i class="fa-solid fa-check me-2 mt-1"></i>
                                    <span class="fw-semibold d-flex flex-column">
                                        Confirmed
                                        <small class="text-muted ">Oct 12</small>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        <p class="label">Contact information</p>
                                        <div class="ord-info">
                                            <span>Sunita vaghela</span>
                                            <span>sunitavaghela0106@gmail.com</span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="label mt-3">Shipping address</p>
                                        <div class="ord-info">
                                            <span>Sunita vaghela</span>
                                            <span>Mamlatdar office ni pachd, tarikam nagar, dabhunda road,rapar-Kutch 360005 Rapar Gujarat</span>
                                            <span>India</span>
                                            <span>8488986890</span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="label mt-3">Shipping method</p>
                                        <div class="ord-info">
                                            <span>Shipping method</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <p class="label mt-3 mt-lg-0">Payment</p>
                                        <div class="ord-info">
                                            <span>Cash on Delivery (COD)</span>
                                            <span class="payment-amount">₹539.10 INR</span>
                                            <span class="ord-date">Oct 12</span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="label mt-3">Billing address</p>
                                        <div class="ord-info">
                                            <span>Sunita vaghela</span>
                                            <span>Mamlatdar office ni pachd, tarikam nagar, dabhunda road,rapar-Kutch 360005 Rapar Gujarat</span>
                                            <span>India</span>
                                            <span>8488986890</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 order-1 order-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0 payment-price">₹539.10 INR</p>
                            <div class="msg">
                                <p class="mb-2">This order has a pending payment. The balance will be updated when payment is received.</p>
                                <p class="mb-0">Thank you for choosing cash on delivery.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4 payment-info d-none d-lg-block">
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <div class=payment-product>
                                        <div class="image">
                                            <img src="assets/images/pro-3.jpg" alt="">
                                        </div>
                                        <div>
                                            <p class="mb-0">THR3E STROKES Spider Gel Kit: 2 Colors with Nail Art Brushes</p>
                                        </div>
                                        <div class="total-product">1</div>
                                    </div>
                                    <div>₹499.00</div>
                                </li>
                                <li>
                                    <div>Subtotal</div>
                                    <div>₹499.00</div>
                                </li>
                                <li>
                                    <div>Shipping</div>
                                    <div>₹100.00</div>
                                </li>
                                <li>
                                    <div>Total</div>
                                    <div>₹599.00</div>
                                </li>
                                <li>
                                    <div>Paid</div>
                                    <div>₹59.00</div>
                                </li>
                                <li>
                                    <div>Total</div>
                                    <div><span> inr </span> ₹539.10</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@include('front.dashboard.footer')
