@forelse($products as $index => $product)
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
    if (!is_array($otherImages)) {
        $otherImages = [];
    }
    $backImage = $product->back_image ? asset('product/' . $product->back_image) : ($otherImages && count($otherImages) > 0 ? asset('product/' . $otherImages[0]) : asset('product/' . $product->image));
    $mainImage = asset('product/' . $product->image);
    
    // Delay class for animation - match the main product page
    $delayClass = 'delay-' . (($index % 4) + 1) * 10;
@endphp
<div class="col-lg-3 col-md-6 col-6">
    <div class="product animate-on-scroll slide-up {{ $delayClass }}" style="opacity: 1; visibility: visible;">
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
                    <a href="{{ route('product.detail', $product->id) }}">
                        <ul>
                            @for($i = 0; $i < 5; $i++)
                                <li><i class="fa-solid fa-star"></i></li>
                            @endfor
                            <li><span>({{ $reviewCount }})</span></li>
                        </ul>
                        <div class="product-price">
                            @if($hasDiscount)
                                <del> RS. {{ number_format($product->price, 2) }}</del>
                            @endif
                            <p>RS. {{ number_format($finalPrice, 2) }}</p>
                        </div>
                    </a>
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
<div class="col-12">
    <div class="text-center py-5">
        <p class="mb-0">No products found.</p>
    </div>
</div>
@endforelse

