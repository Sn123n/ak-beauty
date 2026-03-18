@include('front.layouts.header')
<div class="main">
    <section class="category-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-header">
                        <h1 class="page-title">{{ $meta_title ?? 'Product Categories' }}</h1>
                        <p class="page-description">{{ $meta_description ?? 'Browse our wide range of nail art products and accessories' }}</p>
                    </div>
                </div>
            </div>
            
            @if($category)
                <div class="row">
                    <div class="col-12">
                        <div class="category-info">
                            <h2>{{ $category->name }}</h2>
                            @if($category->content)
                                <div class="category-description">
                                    {!! $category->content !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-3">
                        <div class="category-sidebar">
                            <h3>Categories</h3>
                            <ul class="category-list">
                                @foreach($categories as $cat)
                                    <li>
                                        <a href="{{ route('products.filter') }}?category_id={{ $cat->id }}" 
                                           class="{{ $cat->id == $category->id ? 'active' : '' }}">
                                            {{ $cat->name }}
                                            @if($cat->products_count > 0)
                                                <span class="count">({{ $cat->products_count }})</span>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            
                            <div class="price-filter">
                                <h4>Price Range</h4>
                                <div class="price-range">
                                    <input type="range" id="price-range" min="0" max="{{ $maxPrice ?? 5000 }}" value="{{ $maxPrice ?? 5000 }}">
                                    <div class="range-values">
                                        <span>Rs. 0</span>
                                        <span id="max-price-value">Rs. {{ $maxPrice ?? 5000 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-9">
                        <div class="products-grid">
                            <div class="products-header">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <p class="products-count">Showing {{ $products->count() }} products</p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="sort-dropdown">
                                            <select id="sort-products" class="form-select">
                                                <option value="latest">Latest First</option>
                                                <option value="price-low">Price: Low to High</option>
                                                <option value="price-high">Price: High to Low</option>
                                                <option value="name">Name: A to Z</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row products-container">
                                @forelse($products as $product)
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
                                    <div class="col-md-6 col-lg-4">
                                        <div class="product-card">
                                            <div class="product-image">
                                                <a href="{{ route('product.detail', $product->id) }}">
                                                    <img src="{{ asset('product/' . $product->image) }}" alt="{{ $product->title }}">
                                                    @if($product->back_image)
                                                        <img src="{{ asset('product/' . $product->back_image) }}" alt="{{ $product->title }}" class="back-image">
                                                    @endif
                                                    @if($hasDiscount)
                                                        <div class="sale-badge">Sale</div>
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="product-info">
                                                <h4>
                                                    <a href="{{ route('product.detail', $product->id) }}">
                                                        {{ $product->title }}
                                                    </a>
                                                </h4>
                                                <div class="product-rating">
                                                    <div class="stars">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fa-solid fa-star {{ $i <= ($product->average_rating ?? 0) ? 'filled' : '' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <span>({{ $reviewCount }})</span>
                                                </div>
                                                <div class="product-price">
                                                    @if($hasDiscount)
                                                        <span class="original-price">Rs. {{ number_format($product->price, 2) }}</span>
                                                    @endif
                                                    <span class="current-price">Rs. {{ number_format($finalPrice, 2) }}</span>
                                                </div>
                                                <div class="product-actions">
                                                    <a href="{{ route('product.detail', $product->id) }}" class="btn btn-outline">View Details</a>
                                                    <button class="btn btn-primary add-to-cart-btn" 
                                                            data-product-id="{{ $product->id }}"
                                                            data-product-title="{{ $product->title }}"
                                                            data-product-price="{{ $product->price }}"
                                                            data-product-discount="{{ $product->discount ?? 0 }}"
                                                            data-product-discount-type="{{ $product->discount_type ?? '' }}"
                                                            data-product-image="{{ $product->image }}"
                                                            data-product-category-id="{{ $product->category_id }}">
                                                        Add to Cart
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="no-products">
                                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                            <h4>No products found in this category</h4>
                                            <p>Check back later or browse other categories.</p>
                                            <a href="{{ route('index') }}" class="btn btn-primary">Continue Shopping</a>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            
                            @if($products->hasPages())
                                <div class="pagination-wrapper">
                                    {{ $products->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <!-- Show all categories when no specific category is selected -->
                <div class="row categories-grid">
                    @forelse($categories as $cat)
                        <div class="col-md-6 col-lg-4">
                            <div class="category-card">
                                <div class="category-image">
                                    @if($cat->image)
                                        <img src="{{ asset('categories/' . $cat->image) }}" alt="{{ $cat->name }}">
                                    @else
                                        <img src="{{ asset('client_assets/images/no-image.png') }}" alt="{{ $cat->name }}">
                                    @endif
                                </div>
                                <div class="category-info">
                                    <h3>{{ $cat->name }}</h3>
                                    @if($cat->content)
                                        <p>{{ Str::limit(strip_tags($cat->content), 100) }}</p>
                                    @endif
                                    <div class="category-stats">
                                        <span>{{ $cat->products_count ?? 0 }} Products</span>
                                    </div>
                                    <a href="{{ route('products.filter') }}?category_id={{ $cat->id }}" class="btn btn-primary">
                                        View Products
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="no-categories">
                                <i class="fas fa-layer-group fa-3x text-muted mb-3"></i>
                                <h4>No categories available</h4>
                                <p>Categories will be shown here once they are added.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            @endif
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    // Price range slider
    $('#price-range').on('input', function() {
        var maxValue = $(this).val();
        $('#max-price-value').text('Rs. ' + maxValue);
        
        // Filter products by price
        filterProducts();
    });
    
    // Sort products
    $('#sort-products').change(function() {
        var sortBy = $(this).val();
        var url = new URL(window.location);
        url.searchParams.set('sort', sortBy);
        window.location.href = url.toString();
    });
    
    function filterProducts() {
        var maxPrice = $('#price-range').val();
        var url = new URL(window.location);
        url.searchParams.set('max_price', maxPrice);
        window.location.href = url.toString();
    }
    
    // Add to cart functionality
    $('.add-to-cart-btn').click(function() {
        var $btn = $(this);
        var productId = $btn.data('product-id');
        var productData = {
            id: productId,
            title: $btn.data('product-title'),
            price: $btn.data('product-price'),
            discount: $btn.data('product-discount'),
            discount_type: $btn.data('product-discount-type'),
            image: $btn.data('product-image'),
            category_id: $btn.data('product-category-id'),
            qnty: 1
        };
        
        $.post('{{ route("add.to.cart") }}', productData, function(response) {
            if (response.success) {
                // Update cart count
                updateCartCount();
                // Show success message
                showCartNotification('Product added to cart successfully!');
                // Update button state
                $btn.text('Added to Cart').removeClass('btn-primary').addClass('btn-success');
                setTimeout(function() {
                    $btn.text('Add to Cart').removeClass('btn-success').addClass('btn-primary');
                }, 2000);
            } else {
                showCartNotification('Failed to add product to cart', 'error');
            }
        }).fail(function() {
            showCartNotification('Something went wrong. Please try again.', 'error');
        });
    });
    
    function updateCartCount() {
        $.get('{{ route("cart.count") }}', function(response) {
            $('#cart-count-badge').text(response.count).show();
        });
    }
    
    function showCartNotification(message, type = 'success') {
        // You can implement a nice notification system here
        alert(message);
    }
});
</script>

@include('front.layouts.footer')
