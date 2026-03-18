@include('front.layouts.header')
     <div class="main">
        <section class="home-banner">
            <div class="home-carousel">
                @forelse($sliders as $slider)
                <div class="item">
                    <div class="main-banner">
                        <div class="banner-image">
                            <img src="{{ asset('slider/' . $slider->image) }}" alt="{{ $slider->name }}">
                        </div>
                        <div class="container ">
                            <div class="banner-content slide-up animate-on-scroll delay-2">
                                <div >
                                    <h1 class="banner-title">{{ $slider->name }}</h1>
                                </div>
                                <p>{!! $slider->content !!}</p>
                                @if($slider->button_text && $slider->button_link)
                                <a href="{{ $slider->button_link }}" class="btn ak-btn">{{ $slider->button_text }}</a>
                                @elseif($slider->button_text)
                                <button class="btn ak-btn">{{ $slider->button_text }}</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="item">
                    <div class="main-banner">
                        <div class="banner-image">
                            <img src="assets/images/banner-2.png" alt="">
                        </div>
                        <div class="container ">
                            <div class="banner-content slide-up animate-on-scroll delay-2">
                                <div >
                                    <h1 class="banner-title">Elevate your nail game with our premium quality nail art essentials</h1>
                                </div>
                                <p>We're dedicated to helping you to discover the endless possibilities of nail art and extensions.</p>
                                <button class="btn ak-btn">Shop Products</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
            <div class="slick-counter"></div>
        </section>
        <section class="trend">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-9 col-lg-6 col-xxl-7">
                        <div class="sec-title">
                            <h2 class="section-top-title animate-on-scroll slide-up delay-2">Trendsetting</h2>
                            <h3 class="section-main-title animate-on-scroll slide-up delay-2">
                                Salon-Ready Nails in Seconds!
                            </h3>
                            <h3 class="section-main-title-two animate-on-scroll slide-up delay-2">
                                POLYGEL EXTENTION NAIL KIT
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="product-list">
                    <div class="row">
                        @forelse($products->take(4) as $product)
                        @php
                            // Calculate final price with discount
                            if ($product->discount && $product->discount_type) {
                                if ($product->discount_type == 'percent') {
                                    $finalPrice = $product->price - ($product->price * $product->discount / 100);
                                } elseif ($product->discount_type == 'rs') {
                                    $finalPrice = $product->price - $product->discount;
                                } else {
                                    $finalPrice = $product->price;
                                }
                            } else {
                                $finalPrice = $product->price;
                            }
                            $finalPrice = max($finalPrice, 0);
                            $hasDiscount = $product->discount && $product->discount > 0;
                            $reviewCount = $product->review ? $product->review->count() : 0;
                        @endphp
                        <div class="col-md-6 col-lg-3 col-md-3 col-6">
                            <div class="product animate-on-scroll slide-up">
                                <div class="pro-image">
                                    <a href="{{ route('product.detail', $product->id) }}">
                                        <img src="{{ asset('product/' . $product->image) }}" alt="{{ $product->title }}" class="pro-1">
                                        @if($product->back_image)
                                            <img src="{{ asset('product/' . $product->back_image) }}" alt="{{ $product->title }}" class="pro-2">
                                        @else
                                            <img src="{{ asset('product/' . $product->image) }}" alt="{{ $product->title }}" class="pro-2">
                                        @endif
                                        @if($hasDiscount)
                                            <div class="card__badge badge"><span>Sale</span></div>
                                        @endif
                                    </a>
                                </div>
                                <div class="pro-content">
                                    <div class="pro-main">
                                        <div class="product-name">
                                            <h5>
                                                <a href="{{ route('product.detail', $product->id) }}">
                                                    {{ $product->title }}
                                                </a>
                                            </h5>
                                        </div>
                                        <div class="pro-rate">
                                            <ul>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><span>({{ $reviewCount }})</span></li>
                                            </ul>
                                            <div class="product-price">
                                                @if($hasDiscount)
                                                    <del>RS. {{ number_format($product->price, 2) }}</del>
                                                @endif
                                                <p>RS. {{ number_format($finalPrice, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-btn">
                                    <a href="{{ route('product.detail', $product->id) }}" class="btn ak-btn w-100 mb-2">Choose Options</a>
                                    <a href="javascript:void(0);" class="btn ak-btn btn-two w-100 add-to-cart-btn" 
                                       data-product-id="{{ $product->id }}"
                                       data-product-title="{{ $product->title }}"
                                       data-product-price="{{ $product->price }}"
                                       data-product-discount="{{ $product->discount ?? 0 }}"
                                       data-product-discount-type="{{ $product->discount_type ?? '' }}"
                                       data-product-image="{{ $product->image }}"
                                       data-product-category-id="{{ $product->category_id }}">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-md-6 col-lg-3 col-md-3 col-6">
                            <div class="product animate-on-scroll slide-up">
                                <div class="pro-image">
                                    <a href="product-details.php">
                                        <img src="assets/images/tred-1.jpg" alt="" class="pro-1">
                                        <img src="assets/images/tred-1-1.jpg" alt="" class="pro-2">
                                    </a>
                                </div>
                                <div class="pro-content">
                                    <div class="pro-main">
                                        <div class="product-name">
                                            <h5>
                                                <a href="product-details.php">
                                                    Poly Nail Gel Extension Kit - Nude, Pink, White (12 Items)
                                                </a>
                                            </h5>
                                        </div>
                                        <div class="pro-rate">
                                            <ul>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><span>(20)</span></li>
                                            </ul>
                                            <div class="product-price">
                                                <del> RS. 4,999.00</del>
                                                <p>RS. 1,499.00</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-btn">
                                    <a href="product-details.php" class="btn ak-btn w-100">Add to cart</a>
                                </div>
                            </div>
                        </div>
                        @endforelse
                        <div class="col-lg-12">
                            <div class="text-center view-btn animate-on-scroll slide-up delay-5 w-100">
                                <a href="{{ route('product.list') }}" class="btn ">View all</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="home-mid-product">
            <div class="container">
                <div class="im-vi">
                    @if($frenchManicure)
                    @php
                        // Check if image2 is a video by file extension
                        $isVideo = false;
                        if ($frenchManicure->image2) {
                            $extension = strtolower(pathinfo($frenchManicure->image2, PATHINFO_EXTENSION));
                            $videoExtensions = ['mp4', 'mov', 'webm', 'avi', 'mkv', 'flv', 'wmv'];
                            $isVideo = in_array($extension, $videoExtensions);
                        }
                    @endphp
                    <div class="row animate-on-scroll slide-up delay-5">
                        <div class="col-md-6 col-lg-6">
                            <div class="im-img">
                                @if($frenchManicure->image)
                                    <img src="{{ asset('jewellry/' . $frenchManicure->image) }}" alt="{{ $frenchManicure->title ?? 'image not found' }}">
                                @else
                                    <img src="assets/images/im-1.jpg" alt="image not found">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="im-img">
                                <div class="im-content">
                                    <h2>{{ $frenchManicure->title ?? 'French Manicure Kit' }}</h2>
                                    <p>{!! $frenchManicure->content ?? 'The kit includes easy-to-use tools that simplify the DIY process, allowing even beginners to create flawless French nails effortlessly in just 10 seconds.' !!}</p>
                                    @if($frenchManicure->button_text && $frenchManicure->button_link)
                                        <a href="{{ $frenchManicure->button_link }}" class="btn ak-btn">{{ $frenchManicure->button_text }}</a>
                                    @elseif($frenchManicure->button_text)
                                        <button class="btn ak-btn">{{ $frenchManicure->button_text }}</button>
                                    @else
                                        <button class="btn ak-btn">Shop Products</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row animate-on-scroll slide-up delay-15">
                        <div class="col-md-6 col-lg-6 ord-2">
                            <div class="im-img">
                                <div class="im-content">
                                    <h2>{{ $frenchManicure->title2 ?? 'Nail the Perfect Look' }}</h2>
                                    <p>{!! $frenchManicure->content2 ?? 'Whether you\'re a professional nail artist or a DIY enthusiast, we are here to provide you with the highest quality products and tools to bring your nail creations to life.' !!}</p>
                                    @if($frenchManicure->button_text && $frenchManicure->button_link)
                                        <a href="{{ $frenchManicure->button_link }}" class="btn ak-btn">{{ $frenchManicure->button_text }}</a>
                                    @elseif($frenchManicure->button_text)
                                        <button class="btn ak-btn">{{ $frenchManicure->button_text }}</button>
                                    @else
                                        <button class="btn ak-btn">Shop Products</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 ord-1">
                            <div class="im-img">
                                @if($frenchManicure->image2)
                                    @if($isVideo)
                                        <video src="{{ asset('jewellry/' . $frenchManicure->image2) }}" muted autoplay loop>
                                            <source src="{{ asset('jewellry/' . $frenchManicure->image2) }}" type="video/{{ $extension }}">
                                        </video>
                                    @else
                                        <img src="{{ asset('jewellry/' . $frenchManicure->image2) }}" alt="{{ $frenchManicure->title2 ?? 'image not found' }}">
                                    @endif
                                @else
                                    <video src="https://cdn.shopify.com/videos/c/o/v/0e7ff66cb5c14f269a0a13cc09149689.mp4" muted autoplay loop>
                                        <source src="https://cdn.shopify.com/videos/c/o/v/0e7ff66cb5c14f269a0a13cc09149689.mp4" type="video/mp4">
                                    </video>
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                    {{-- Static fallback content --}}
                    <div class="row animate-on-scroll slide-up delay-5">
                        <div class="col-md-6 col-lg-6">
                            <div class="im-img">
                                <img src="assets/images/im-1.jpg" alt="image not found">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="im-img">
                                <div class="im-content">
                                    <h2>French Manicure Kit</h2>
                                    <p>The kit includes easy-to-use tools that simplify the DIY process, allowing even beginners to create flawless French nails effortlessly in just 10 seconds.</p>
                                    <button class="btn ak-btn">Shop Products</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row animate-on-scroll slide-up delay-15">
                        <div class="col-md-6 col-lg-6 ord-2">
                            <div class="im-img">
                                <div class="im-content">
                                    <h2>Nail the Perfect Look</h2>
                                    <p>Whether you're a professional nail artist or a DIY enthusiast, we are here to provide you with the highest quality products and tools to bring your nail creations to life.</p>
                                    <button class="btn ak-btn">Shop Products</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 ord-1">
                            <div class="im-img">
                                <video src="https://cdn.shopify.com/videos/c/o/v/0e7ff66cb5c14f269a0a13cc09149689.mp4" muted autoplay loop>
                                    <source src="https://cdn.shopify.com/videos/c/o/v/0e7ff66cb5c14f269a0a13cc09149689.mp4" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="s-product">
                    @forelse($homeCategories as $category)
                    <div class="simple-product">
                        <div class="simple-image">
                            <a href="{{ route('products.filter') }}?category_id={{ $category->id }}">
                                @if($category->homeimage)
                                    <img src="{{ asset('categories/' . $category->homeimage) }}" alt="{{ $category->name }}">
                                @elseif($category->image)
                                    <img src="{{ asset('categories/' . $category->image) }}" alt="{{ $category->name }}">
                                @else
                                    <img src="assets/images/simp-1.jpg" alt="{{ $category->name }}">
                                @endif
                            </a>
                        </div>
                        <div class="simple-product-name">
                            <h4>{{ $category->name }} <i class="fa-solid fa-arrow-right-long"></i></h4>
                        </div>
                    </div>
                    @empty
                    <div class="simple-product">
                        <div class="simple-image">
                            <a href="javascrpit:void(0);">
                                <img src="assets/images/simp-1.jpg" alt="">
                            </a>
                        </div>
                        <div class="simple-product-name">
                            <h4>Press-on-Nails <i class="fa-solid fa-arrow-right-long"></i></h4>
                        </div>
                    </div>
                    <div class="simple-product">
                        <div class="simple-image">
                            <a href="javascrpit:void(0);">
                                <img src="assets/images/simp-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="simple-product-name">
                            <h4>POLYGEL Nail Extension Kit <i class="fa-solid fa-arrow-right-long"></i></h4>
                        </div>
                    </div>
                    <div class="simple-product">
                        <div class="simple-image">
                            <a href="javascrpit:void(0);">
                                <img src="assets/images/simp-3.jpg" alt="">
                            </a>
                        </div>
                        <div class="simple-product-name">
                            <h4>Nail Essential <i class="fa-solid fa-arrow-right-long"></i></h4>
                        </div>
                    </div>
                    <div class="simple-product">
                        <div class="simple-image">
                            <a href="javascrpit:void(0);">
                                <img src="assets/images/simp-4.jpg" alt="">
                            </a>
                        </div>
                        <div class="simple-product-name">
                            <h4>DIY Nail Art  <i class="fa-solid fa-arrow-right-long"></i></h4>
                        </div>
                    </div>
                    @endforelse
                </div>
                <div class="slick-counter s-pro"></div>
            </div>
        </section>
        <section class="three-stock">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xxl-8">
                        <div class="sec-title">
                            <h2 class="section-top-title animate-on-scroll slide-up delay-5">THR3E STROKES </h2>
                            <h3 class="section-main-title animate-on-scroll slide-up delay-5">
                                Long-Lasting & Skin-Friendly
                            </h3>
                            <p class=" animate-on-scroll slide-up delay-5">From vibrant nail polishes to intricate nail stickers and tools, we handpick each item to ensure that it meets our standards of quality, innovation, and style.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="three-stock-two">
            <div class="container">
                <div class="three-stock-main">
                    @if($nails)
                    <div class="row ">
                        <div class="col-md-6 col-lg-6 ord-2">
                            <div class="three-stock-content animate-on-scroll slide-up delay-5">
                                <div class="sec-title text-start">
                                    <h2 class="section-top-title ms-0 text-decoration-none">THR3E STROKES </h2>
                                </div>
                                <div class="three-stock-title">
                                    <h3>
                                       {!! $nails->title ?? 'Nail Extensions: Lengthen Your Style' !!}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 ord-1">
                            <div class="three-stock-image animate-on-scroll slide-up delay-5">
                                @if($nails->image)
                                    <img src="{{ asset('nails/' . $nails->image) }}" alt="{{ $nails->title ?? 'image not found' }}">
                                @else
                                    <img src="assets/images/three-stock-1.jpg" alt="image not found">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-6 col-lg-6">
                            <div class="three-stock-image animate-on-scroll slide-up delay-5">
                                @if($nails->image2)
                                    <img src="{{ asset('nails/' . $nails->image2) }}" alt="{{ $nails->title ?? 'image not found' }}">
                                @else
                                    <img src="assets/images/three-stock-2.jpg" alt="image not found">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="three-stock-content-two animate-on-scroll slide-up delay-5">
                                <div class="three-info">
                                    <p>{!! $nails->content ?? "Our journey began with a simple vision: To offer a curated selection of nail art supplies that inspire creativity and elevate your nail game." !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row ">
                        <div class="col-md-6 col-lg-6 ord-2">
                            <div class="three-stock-content animate-on-scroll slide-up delay-5">
                                <div class="sec-title text-start">
                                    <h2 class="section-top-title ms-0 text-decoration-none">THR3E STROKES </h2>
                                </div>
                                <div class="three-stock-title">
                                    <h3>
                                       Nail Extensions:
                                       <br>
                                        Lengthen Your Style
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 ord-1">
                            <div class="three-stock-image animate-on-scroll slide-up delay-5">
                                <img src="assets/images/three-stock-1.jpg" alt="image not found">
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-6 col-lg-6">
                            <div class="three-stock-image animate-on-scroll slide-up delay-5">
                                <img src="assets/images/three-stock-2.jpg" alt="image not found">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="three-stock-content-two animate-on-scroll slide-up delay-5">
                                <div class="three-info">
                                    <p>Our journey began with a simple vision: To offer a curated selection of nail art supplies that inspire creativity and elevate your nail game.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        <section class="home-product">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="sec-title">
                            <h3 class="section-main-title animate-on-scroll slide-up delay-5">
                                DIY Nail Art
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="pro-home">
                    @forelse($diyNailArtProducts as $index => $product)
                    @php
                        // Calculate final price with discount
                        if ($product->discount && $product->discount_type) {
                            if ($product->discount_type == 'percent') {
                                $finalPrice = $product->price - ($product->price * $product->discount / 100);
                            } elseif ($product->discount_type == 'rs') {
                                $finalPrice = $product->price - $product->discount;
                            } else {
                                $finalPrice = $product->price;
                            }
                        } else {
                            $finalPrice = $product->price;
                        }
                        $finalPrice = max($finalPrice, 0);
                        $hasDiscount = $product->discount && $product->discount > 0;
                        $reviewCount = $product->review ? $product->review->count() : 0;
                        
                        // Get other images for hover effect
                        $otherImages = $product->other_image ? json_decode($product->other_image, true) : [];
                        $backImage = $product->back_image ? asset('product/' . $product->back_image) : ($otherImages ? asset('product/' . $otherImages[0]) : asset('product/' . $product->image));
                        $mainImage = asset('product/' . $product->image);
                        
                        // Delay classes for animation
                        $delayClass = 'delay-' . (($index + 1) * 10);
                    @endphp
                    <div class="product animate-on-scroll slide-up {{ $delayClass }}">
                        <div class="pro-image">
                            <a href="{{ route('product.detail', $product->id) }}">
                                <img src="{{ $mainImage }}" alt="{{ $product->title }}" class="pro-1">
                                <img src="{{ $backImage }}" alt="{{ $product->title }}" class="pro-2">
                                @if($hasDiscount)
                                <div class="card__badge badge"><span>Sale</span></div>
                                @endif
                            </a>
                        </div>
                        <div class="pro-content">
                            <div class="pro-main">
                                <div class="product-name">
                                    <h5>
                                        <a href="{{ route('product.detail', $product->id) }}">
                                            {{ $product->title }}
                                        </a>
                                    </h5>
                                </div>
                                <div class="pro-rate">
                                    <ul>
                                        @for($i = 0; $i < 5; $i++)
                                        <li><i class="fa-solid fa-star"></i></li>
                                        @endfor
                                        <li><span>({{ $reviewCount }})</span></li>
                                    </ul>
                                    <div class="product-price">
                                        @if($hasDiscount)
                                        <del>RS. {{ number_format($product->price, 2) }}</del>
                                        @endif
                                        <p>RS. {{ number_format($finalPrice, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pro-btn">
                            <a href="{{ route('product.detail', $product->id) }}" class="btn ak-btn w-100">Choose Options</a>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center">
                        <p>No products found in DIY Nail Art category.</p>
                    </div>
                    @endforelse
                </div>
                <div class="slick-counter"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center view-btn animate-on-scroll slide-up delay-5 w-100">
                            @if(isset($diyNailArtCategory) && $diyNailArtCategory)
                            <a href="{{ route('products.filter', ['category_id' => $diyNailArtCategory->id]) }}" class="btn">View all</a>
                            @else
                            <a href="{{ route('products.filter') }}" class="btn">View all</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="cta">
            @if($deals && $deals->count() > 0)
                @php $deal = $deals->first(); @endphp
                <div class="cta-main-image animate-on-scroll slide-up delay-5">
                    @if($deal->image)
                        <img src="{{ asset('dealday/' . $deal->image) }}" alt="{{ $deal->title }}">
                    @else
                        <img src="assets/images/cta.jpg" alt="image not found">
                    @endif
                </div>
                <div class="container">
                    <div class="cta-content animate-on-scroll slide-up delay-10">
                        <div class="cta-title">
                            <h3>
                                {{ $deal->title ?? 'Get Inspired, Get Creative' }}
                            </h3>
                            <p>{!! $deal->detail ?? "We've curated a carefully selected range of nail art kit, decals, brushes, gel and accessories." !!}</p>
                            <button class="btn ak-btn">Shop Now</button>
                        </div>
                    </div>
                </div>
            @else
                <div class="cta-main-image animate-on-scroll slide-up delay-5">
                    <img src="assets/images/cta.jpg" alt="image not found">
                </div>
                <div class="container">
                    <div class="cta-content animate-on-scroll slide-up delay-10">
                        <div class="cta-title">
                            <h3>
                                Get Inspired, Get Creative
                            </h3>
                            <p>We've curated a carefully selected range of nail art kit, decals, brushes, gel and accessories.</p>
                            <button class="btn ak-btn">Shop Now</button>
                        </div>
                    </div>
                </div>
            @endif
        </section>
        <section class="quality">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-8">
                        <div class="sec-title px-2">
                            <div class="quality-rate animate-on-scroll slide-up delay-5">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <h3 class="quality-title animate-on-scroll slide-up delay-5">love the quality</h3>
                            <div class="quality-info animate-on-scroll slide-up delay-5">
                                <p>I've been a passionate nail artist for years, and finding high-quality products that truly inspire me has always been a challenge. That's why I'm so grateful to have discovered this store, Their selection of nail art kits and accessories is unmatched.</p>
                                <p class="quality-name">- ASHWINI PANDEY </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="free-services">
            <div class="container">
                <div class="service-slider">
                    @forelse($footers as $footer)
                    <div class="item">
                        <div>
                            <div class="services-image">
                                @if($footer->image)
                                    <img src="{{ asset('footericon/' . $footer->image) }}" alt="{{ $footer->title }}">
                                @else
                                    <img src="assets/images/delivery-box.png" alt="{{ $footer->title }}">
                                @endif
                            </div>
                            <div class="service-info">
                                <div class="sec-title">
                                    <h3>{{ $footer->title ?? 'Service' }}</h3>
                                    <p>{!! $footer->detail ?? 'Service description' !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="item">
                        <div>
                            <div class="services-image">
                                <img src="assets/images/delivery-box.png" alt="">
                            </div>
                            <div class="service-info">
                                <div class="sec-title">
                                    <h3>Fast Shipping</h3>
                                    <p>Just order and relax, we value of your time.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div>
                            <div class="services-image">
                                <img src="assets/images/guarantee-certificate.png" alt="">
                            </div>
                            <div class="service-info">
                                <div class="sec-title">
                                    <h3>100% Guranteed</h3>
                                    <p>We always provide high-quality material.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div>
                            <div class="services-image">
                                <img src="assets/images/customer-support.png" alt="">
                            </div>
                            <div class="service-info">
                                <div class="sec-title">
                                    <h3>Customer Support</h3>
                                    <p>Contact us 24 hours a day, 7 days a week.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div>
                            <div class="services-image">
                                <img src="assets/images/secure-payment_1.png" alt="">
                            </div>
                            <div class="service-info">
                                <div class="sec-title">
                                    <h3>Secure payment </h3>
                                    <p>All checkout payments are secure & trusted</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
                <div class="slick-counter"></div>
            </div>
        </section>
    </div>
@include('front.layouts.footer')
<script>
    // Add to Cart functionality for home page
    $(document).ready(function() {
        $(document).on('click', '.add-to-cart-btn', function(e) {
            e.preventDefault();
            const btn = $(this);
            const originalText = btn.text();
            btn.prop('disabled', true).text('Adding...');

            const productId = btn.data('product-id');
            const productTitle = btn.data('product-title');
            const productPrice = btn.data('product-price');
            const productDiscount = btn.data('product-discount') || 0;
            const productDiscountType = btn.data('product-discount-type') || '';
            const productImage = btn.data('product-image');
            const productCategoryId = btn.data('product-category-id');

            $.ajax({
                url: '{{ route("add.to.cart") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: productId,
                    title: productTitle,
                    price: productPrice,
                    discount: productDiscount,
                    discount_type: productDiscountType,
                    image: productImage,
                    category_id: productCategoryId,
                    qnty: 1
                },
                success: function(response) {
                    btn.prop('disabled', false).text(originalText);
                    if (response.message) {
                        if (typeof showCartNotification === 'function') {
                            showCartNotification(response.message);
                        } else {
                            alert(response.message);
                        }
                    }
                    // Update cart count badge
                    if (typeof updateCartCount === 'function') {
                        updateCartCount();
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text(originalText);
                    let errorMsg = 'Something went wrong. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    if (typeof showCartNotification === 'function') {
                        showCartNotification(errorMsg);
                    } else {
                        alert(errorMsg);
                    }
                }
            });
        });
    });
</script>

