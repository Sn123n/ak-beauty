@include('front.layouts.header')
<div class="main">
    <section class="product-banner">
        <div class="container">
            <div class="row">
                <div class="col custom-col-one">
                    @php
                        // Get all product images
                        $productImages = [];
                        if ($product->image) {
                            $productImages[] = asset('product/' . $product->image);
                        }
                        if ($product->back_image) {
                            $productImages[] = asset('product/' . $product->back_image);
                        }
                        if ($product->other_image) {
                            $otherImages = json_decode($product->other_image, true);
                            if (is_array($otherImages)) {
                                foreach ($otherImages as $img) {
                                    if ($img) {
                                        $productImages[] = asset('product/' . $img);
                                    }
                                }
                            }
                        }
                        // If no images, use default placeholder
                        if (empty($productImages) && $product->image) {
                            $productImages[] = asset('product/' . $product->image);
                        }
                        // If still empty, add placeholder
                        if (empty($productImages)) {
                            $productImages[] = asset('client_assets/images/no-image.png');
                        }
                    @endphp
                    <div class="product-for">
                        @foreach($productImages as $index => $img)
                        <div class="pro-detail-image">
                            <img src="{{ $img }}" alt="{{ $product->title }} - Image {{ $index + 1 }}">
                        </div>
                        @endforeach
                    </div>

                    <div class="product-nav">
                        @foreach($productImages as $index => $img)
                        <div class="product-thumb"><img src="{{ $img }}" alt="{{ $product->title }} - Thumb {{ $index + 1 }}"></div>
                        @endforeach
                    </div>
                </div>
                <div class="col custom-col-two">
                    <div class="product-main-details">
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
                            $reviewCount = $reviews->count();
                            $averageRating = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 0;
                        @endphp
                        <div class="rate">
                            <a href="javascript:void(0);">
                                <ul>
                                    @for($i = 0; $i < 5; $i++)
                                        <li><i class="fa-{{ $i < $averageRating ? 'solid' : 'regular' }} fa-star"></i></li>
                                    @endfor
                                    <li><span>{{ $reviewCount }} {{ $reviewCount == 1 ? 'review' : 'reviews' }}</span></li>
                                </ul>
                            </a>
                        </div>
                        <div class="product-det-name">
                            <h2>{{ $product->title }}</h2>
                        </div>
                        <div class="product-price">
                            @if($hasDiscount)
                                <del>RS. {{ number_format($product->price, 2) }}</del>
                            @endif
                            <p>RS. {{ number_format($finalPrice, 2) }}</p>
                            @if($hasDiscount)
                                <div class="pro_det__badge badge"><span>Sale</span></div>
                            @endif
                        </div>
                        <p>Tax included. <a href="javascript:void(0);">Shipping</a> calculated at checkout. </p>
                        @php
                            // Ensure variations is an array, decode if it's a JSON string
                            $productVariations = $product->variations ?? [];
                            if (is_string($productVariations)) {
                                $productVariations = json_decode($productVariations, true) ?? [];
                            }
                            if (!is_array($productVariations)) {
                                $productVariations = [];
                            }
                            $defaultVariation = collect($productVariations)->firstWhere('is_default', true);
                            $selectedVariation = $defaultVariation ?? ($productVariations[0] ?? null);
                        @endphp
                        @if(!empty($productVariations))
                        <div class="color-style">
                            <span class="mb-3 d-block">Style</span>
                            <ul id="variation-list">
                                @foreach($productVariations as $index => $variation)
                                    <li>
                                        <a href="javascript:void(0);" 
                                           class="variation-option {{ ($variation['is_default'] ?? false) ? 'active' : '' }}"
                                           data-variation-index="{{ $index }}"
                                           data-variation-name="{{ $variation['name'] }}"
                                           data-variation-price="{{ $variation['price'] ?? $finalPrice }}"
                                           data-variation-sku="{{ $variation['sku'] ?? '' }}">
                                            {{ $variation['name'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="support-provid">
                            <ul>
                                <li>
                                    <i class="fa-regular fa-truck"></i>
                                    <p> Free Shipping</p>
                                </li>
                                <li>
                                    <i class="fa-solid fa-lock"></i>
                                    <p>10% Off On Prepaid Orders</p>
                                </li>
                                <li>
                                    <i class="fa-regular fa-star"></i>
                                    <p>More than 15421+ Customers Purchased in the last 30 Days</p>
                                </li>
                                <li>
                                    <i class="fa-solid fa-square-check"></i>
                                    <p>No Harmful Chemicals</p>
                                </li>
                                <li>
                                    <i class="fa-solid fa-box"></i>
                                    <p>Cash On Delivery Available</p>
                                </li>
                            </ul>
                        </div>
                        <input type="hidden" id="selected-variation" value="{{ $selectedVariation['name'] ?? '' }}">
                        <div class="qty-count">
                            <span class="d-block">Quantity (1 in cart) </span>
                            <div class="quantity">
                                <button class="qty-btn minus" type="button">-</button>
                                <input type="text" class="qty-input" id="product-quantity" value="1" readonly>
                                <button class="qty-btn plus" type="button">+</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="product-details-btn">
                                    <div class="mb-3">
                                        <a href="javascript:void(0);" class="btn ak-btn btn-two" id="add-to-cart-btn">Add to cart</a>
                                    </div>
                                    <div class="buy-btn">
                                        <a href="javscript:void(0);" class="btn ak-btn btn-two">Buy it now
                                            <div>
                                                <img src="assets/images/paytm.png" alt="">
                                            </div>
                                            <div>
                                                <img src="assets/images/phonepe.png" alt="">
                                            </div>
                                            <div>
                                                <img src="assets/images/google.png" alt="">
                                            </div>
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="product-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="sec-title title-two text-start">
                        <h3 class="section-main-title animate-on-scroll slide-up delay-2">
                            You May Also Like
                        </h3>
                    </div>
                </div>
            </div>
            <div class="product-list">
                <div class="row">
                    @forelse($relatedProducts as $relatedProduct)
                        @php
                            // Calculate final price with discount for related product
                            if ($relatedProduct->discount && $relatedProduct->discount_type) {
                                if ($relatedProduct->discount_type == 'percent') {
                                    $relatedFinalPrice = $relatedProduct->price - ($relatedProduct->price * $relatedProduct->discount / 100);
                                } elseif ($relatedProduct->discount_type == 'rs') {
                                    $relatedFinalPrice = $relatedProduct->price - $relatedProduct->discount;
                                } else {
                                    $relatedFinalPrice = $relatedProduct->price;
                                }
                            } else {
                                $relatedFinalPrice = $relatedProduct->price;
                            }
                            $relatedFinalPrice = max($relatedFinalPrice, 0);
                            $relatedHasDiscount = $relatedProduct->discount && $relatedProduct->discount > 0;
                            $relatedReviewCount = $relatedProduct->review ? $relatedProduct->review->count() : 0;

                            // Get other images for hover effect
                            $relatedOtherImages = [];
                            if ($relatedProduct->other_image) {
                                $decoded = is_string($relatedProduct->other_image) ? json_decode($relatedProduct->other_image, true) : $relatedProduct->other_image;
                                $relatedOtherImages = is_array($decoded) ? $decoded : [];
                            }
                            $relatedBackImage = $relatedProduct->back_image ? asset('product/' . $relatedProduct->back_image) : (!empty($relatedOtherImages) && count($relatedOtherImages) > 0 ? asset('product/' . $relatedOtherImages[0]) : asset('product/' . $relatedProduct->image));
                            $relatedMainImage = asset('product/' . $relatedProduct->image);
                        @endphp
                        <div class="col-lg-3 col-md-6 col-6">
                            <div class="product animate-on-scroll slide-up">
                                <div class="pro-image">
                                    <a href="{{ route('product.detail', $relatedProduct->id) }}">
                                        <img src="{{ $relatedMainImage }}" alt="{{ $relatedProduct->title }}" class="pro-1">
                                        <img src="{{ $relatedBackImage }}" alt="{{ $relatedProduct->title }}" class="pro-2">
                                        @if($relatedHasDiscount)
                                            <div class="card__badge badge"><span>Sale</span></div>
                                        @endif
                                    </a>
                                </div>
                                <div class="pro-content">
                                    <div class="pro-main">
                                        <div class="product-name">
                                            <h5>
                                                <a href="{{ route('product.detail', $relatedProduct->id) }}">
                                                    {{ $relatedProduct->title }}
                                                </a>
                                            </h5>
                                        </div>
                                        <div class="pro-rate">
                                            <a href="{{ route('product.detail', $relatedProduct->id) }}">
                                                <ul>
                                                    @for($i = 0; $i < 5; $i++)
                                                        <li><i class="fa-solid fa-star"></i></li>
                                                    @endfor
                                                    <li><span>({{ $relatedReviewCount }})</span></li>
                                                </ul>
                                                <div class="product-price">
                                                    @if($relatedHasDiscount)
                                                        <del>RS. {{ number_format($relatedProduct->price, 2) }}</del>
                                                    @endif
                                                    <p>RS. {{ number_format($relatedFinalPrice, 2) }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-btn">
                                    <a href="{{ route('product.detail', $relatedProduct->id) }}" class="btn ak-btn w-100">Choose Options</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <p class="mb-0">No related products found.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="sec-title title-two ">
                        <h3 class="section-main-title animate-on-scroll slide-up delay-2">
                            Customer Reviews
                        </h3>
                    </div>
                </div>
            </div>
            <div class="customer-review">
                @php
                    $totalReviews = $reviews->count();
                    $averageRating = $totalReviews > 0 ? round($reviews->avg('rating'), 2) : 0;
                    $ratingCounts = [
                        5 => $reviews->where('rating', 5)->count(),
                        4 => $reviews->where('rating', 4)->count(),
                        3 => $reviews->where('rating', 3)->count(),
                        2 => $reviews->where('rating', 2)->count(),
                        1 => $reviews->where('rating', 1)->count(),
                    ];
                @endphp
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <div class="based-review">
                            <div>
                                <ul>
                                    @for($i = 0; $i < 5; $i++)
                                        <li><i class="fa-{{ $i < floor($averageRating) ? 'solid' : 'regular' }} fa-star"></i></li>
                                    @endfor
                                    <li><span>{{ number_format($averageRating, 2) }} out of 5</span></li>
                                </ul>
                            </div>
                            <div>
                                <span>Based on {{ $totalReviews }} {{ $totalReviews == 1 ? 'review' : 'reviews' }} <img src="assets/images/verified-checkmark.svg" alt=""> </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="review-process">
                            @for($rating = 5; $rating >= 1; $rating--)
                                @php
                                    $count = $ratingCounts[$rating];
                                    $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                @endphp
                                <div class="row mb-2">
                                    <div class="col-lg-5">
                                        <ul>
                                            @for($i = 0; $i < 5; $i++)
                                                <li><i class="fa-{{ $i < $rating ? 'solid' : 'regular' }} fa-star"></i></li>
                                            @endfor
                                        </ul>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="review-slide">
                                            <div class="review-bar" style="width: {{ $percentage }}%;"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <p class="mb-0">{{ $count }}</p>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="w-75">
                            <button class="btn ak-btn w-100" id="toggle-review">Write a reivew</button>
                        </div>
                    </div>
                    <div class="add-review" style="display: none;">
                        <div class="review-star">
                            <h2 class="review-title">
                                Write a review
                            </h2>
                            <p>Rating</p>
                            <ul class="rating">
                                <li><i class="fa-regular fa-star"></i></li>
                                <li><i class="fa-regular fa-star"></i></li>
                                <li><i class="fa-regular fa-star"></i></li>
                                <li><i class="fa-regular fa-star"></i></li>
                                <li><i class="fa-regular fa-star"></i></li>
                            </ul>
                        </div>
                        <div class="review-form">
                            <form action="#">
                                <div class="row justify-content-center">
                                    <div class="col-lg-5">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3 w-100 text-center">
                                                    <label for="">Reviwe Title (100)</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Give your review a title">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="mb-3 w-100 text-center">
                                                    <label for="">Review</label>
                                                    <textarea name="" id="" class="form-control" placeholder="Write your comments here"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="mb-3 w-100 text-center">
                                                    <label for=""
                                                        class="d-flex justify-content-center align-items-center">
                                                        Name (
                                                        displayed publicly like
                                                        <div class="custom-select">
                                                            <select name="sort" id="sort"
                                                                class="custom-select-filter ms-2">
                                                                <option value="manual" selected="selected"> John Smith
                                                                </option>
                                                                <option value="best-selling"> John S.</option>
                                                                <option value="best-selling"> John</option>
                                                                <option value="best-selling"> J.S.</option>
                                                                <option value="best-selling"> Anonymuos</option>
                                                            </select>
                                                        </div>
                                                        )
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter your name(public)">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="upload-section">
                                                    <label for="file-upload" class="upload-label">
                                                        <p>Picture/Video (optional)</p>
                                                        <div class="upload-box">
                                                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                                        </div>
                                                    </label>
                                                    <input id="file-upload" type="file" accept="image/*,video/*"
                                                        hidden>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="mb-3 w-100 text-center">
                                                    <label for="">Email</label>
                                                    <input type="email" class="form-control"
                                                        placeholder="Enter your email(private)">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="text-center desc">
                                                    <p>
                                                        How we use your data: We'll only contect you about the review
                                                        you left, and only if necessary. By submitting your review, you
                                                        agree to Judge. me's
                                                        <a href="javasctipt:void(0)l">terms,</a> <a
                                                            href="javasctipt:void(0)l">privacy</a>and<a
                                                            href="javasctipt:void(0)l">contact</a> policies.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="review-form-btn">
                                                    <button class="btn ak-btn cancel-btn">Cancel review</button>
                                                    <button type="submit" class="btn ak-btn">Submit review</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="review-filter">
                        <div class="custom-select">
                            <select name="sort" id="sort" class="custom-select-filter ms-2">
                                <option value="manual" selected="selected"> Most Recent</option>
                                <option value="best-selling"> High Rating</option>
                                <option value="title-ascending"> Low Rating</option>
                                <option value="title-descending">Only Picture</option>
                                <option value="price-ascending">Picture First</option>
                                <option value="price-descending"> Video First </option>
                                <option value="created-ascending">Most Helpful</option>
                                <option value="created-descending"> Date, new to old</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    @forelse($reviews as $review)
                        <div class="customer-review-details">
                            <div class="customer-show-rate">
                                <ul>
                                    @for($i = 0; $i < 5; $i++)
                                        <li><i class="fa-{{ $i < $review->rating ? 'solid' : 'regular' }} fa-star"></i></li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="customer-profile">
                                <div class="profile-image">
                                    <i class="fa-regular fa-user"></i>
                                </div>
                                <div class="customer-name">
                                    <h3>{{ $review->user ? ($review->user->name ?? 'Anonymous') : 'Anonymous' }}</h3>
                                </div>
                            </div>
                            <div class="customer-product-name">
                                <h4>{{ $review->name ?? 'No Title' }}</h4>
                            </div>
                            <div class="customer-massage">
                                <p>{{ $review->review ?? 'No review provided.' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <p class="mb-0">No reviews yet. Be the first to review this product!</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="col-lg-12">
                    <div class="coustomer-page">
                        <div class="page-num">
                            <ul>
                                <li><a href="javascript:void(0);" class="first" style="display:none;">|<i
                                            class="fa-solid fa-chevron-left"></i></a></li>
                                <li><a href="javascript:void(0);" class="previous" style="display:none;"><i
                                            class="fa-solid fa-chevron-left"></i></a></li>
                                <li><a href="javascript:void(0);" class="active">1</a></li>
                                <li><a href="javascript:void(0);">2</a></li>
                                <li><a href="javascript:void(0);">3</a></li>
                                <li><a href="javascript:void(0);"class="next"><i
                                            class="fa-solid fa-chevron-right"></i></a></li>
                                <li><a href="javascript:void(0);"class="last"><i
                                            class="fa-solid fa-chevron-right"></i>|</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Popup -->

    <div class="popup" id="popup">
        <span class="close" id="close">&times;</span>
        <div id="popup-container"></div>
    </div>
</div>

@include('front.layouts.footer')
<script>
    // Variations Management
    $(document).ready(function() {
        $('.variation-option').on('click', function() {
            // Remove active class from all
            $('.variation-option').removeClass('active');
            // Add active class to clicked
            $(this).addClass('active');
            
            // Get variation data
            const variationPrice = parseFloat($(this).data('variation-price')) || {{ $product->price }};
            const variationName = $(this).data('variation-name');
            const basePrice = {{ $product->price }};
            const discount = {{ $product->discount ?? 0 }};
            const discountType = '{{ $product->discount_type ?? "" }}';
            
            // Calculate final price
            let finalPrice = variationPrice || basePrice;
            if (discount && discountType) {
                if (discountType == 'percent') {
                    finalPrice = finalPrice - (finalPrice * discount / 100);
                } else if (discountType == 'rs') {
                    finalPrice = finalPrice - discount;
                }
            }
            finalPrice = Math.max(finalPrice, 0);
            
            // Update price display
            const formattedPrice = finalPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('.product-price p').text('RS. ' + formattedPrice);
            
            // Store selected variation for add to cart
            $('#selected-variation').val(variationName);
        });
        
        // Quantity increment/decrement - prevent duplicate handlers
        $('.qty-btn.plus').off('click').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const currentQty = parseInt($('#product-quantity').val()) || 1;
            $('#product-quantity').val(currentQty + 1);
        });
        
        $('.qty-btn.minus').off('click').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const currentQty = parseInt($('#product-quantity').val()) || 1;
            if (currentQty > 1) {
                $('#product-quantity').val(currentQty - 1);
            }
        });

        // Add to cart functionality for product detail page - prevent duplicate handlers
        $('#add-to-cart-btn').off('click').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const btn = $(this);
            const originalText = btn.text();
            btn.prop('disabled', true).text('Adding...');

            const productId = {{ $product->id }};
            const productTitle = '{{ addslashes($product->title) }}';
            const productPrice = {{ $product->price }};
            const productDiscount = {{ $product->discount ?? 0 }};
            const productDiscountType = '{{ $product->discount_type ?? "" }}';
            const productImage = '{{ $product->image }}';
            const productCategoryId = {{ $product->category_id }};
            // Get quantity from input - ensure it's a valid number
            const quantityInput = $('#product-quantity').val();
            const quantity = parseInt(quantityInput) || 1;
            const selectedVariation = $('#selected-variation').val() || '';
            
            console.log('Adding to cart - Quantity:', quantity);

            $.ajax({
                url: '{{ route("add.to.cartdetail") }}',
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
                    qnty: quantity,
                    variation: selectedVariation
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
    
    const images = document.querySelectorAll('.product-for .pro-detail-image img');
    const popup = document.getElementById('popup');
    const popupContainer = document.getElementById('popup-container');
    const closeBtn = document.getElementById('close');

    // Clone all images into popup container
    images.forEach(img => {
        const newImg = img.cloneNode();
        popupContainer.appendChild(newImg);
    });

    // Open popup
    images.forEach((img, index) => {
        img.addEventListener('click', () => {
            popup.style.display = 'flex';
            // Scroll to clicked image
            const scrollPosition = popupContainer.children[index].offsetTop;
            popup.scrollTo({
                top: scrollPosition,
                behavior: 'smooth'
            });
        });
    });

    // Close popup
    closeBtn.addEventListener('click', () => {
        popup.style.display = 'none';
    });
</script>
<script>
    const stars = document.querySelectorAll(".rating li i");
    const ratingInput = document.getElementById("rating-value");
    let currentRating = 0; // store locked rating

    function fillStars(count) {
        stars.forEach((star, index) => {
            if (index < count) {
                star.classList.remove("fa-regular");
                star.classList.add("fa-solid");
            } else {
                star.classList.remove("fa-solid");
                star.classList.add("fa-regular");
            }
        });
    }

    // Hover effect (preview)
    stars.forEach((star, index) => {
        star.parentElement.addEventListener("mouseover", () => {
            fillStars(index + 1);
        });

        // Reset on mouseout (back to current rating)
        star.parentElement.addEventListener("mouseout", () => {
            fillStars(currentRating);
        });

        // Lock rating on click
        star.parentElement.addEventListener("click", () => {
            currentRating = index + 1;
            ratingInput.value = currentRating;
            fillStars(currentRating);
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Toggle on "Write a review" button
        $("#toggle-review").click(function(e) {
            e.preventDefault();
            $(".add-review").slideToggle(300); // smooth open/close
        });

        // Close when "Cancel review" button is clicked
        $(document).on("click", ".cancel-btn", function(e) {
            e.preventDefault();
            $(".add-review").slideUp(300);
        });
    });
</script>
