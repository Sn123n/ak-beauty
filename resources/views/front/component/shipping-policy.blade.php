@include('front.layouts.header')
<div class="main">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="sec-title">
                        <h3 class="section-main-title ">
                           {{$shippingpolicy->title ?? ''}}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="policy-details">
                        {!! $shippingpolicy->content ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include('front.layouts.footer')
