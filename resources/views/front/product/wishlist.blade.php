@include('front.layouts.header')
<div class="main">
    <section class="wishlist-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-header">
                        <h1 class="page-title">{{ $meta_title ?? 'My Wishlist' }}</h1>
                        <p class="page-description">{{ $meta_description ?? 'Products you\'ve saved for later' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    @if($wishlists->count() > 0)
                        <div class="wishlist-grid">
                            @foreach($wishlists as $wishlist)
                                @php
                                    $product = $wishlist->product;
                                    if (!$product) continue;
                                    
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
                                <div class="wishlist-item" data-wishlist-id="{{ $wishlist->id }}">
                                    <div class="wishlist-product">
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
                                                <button class="btn btn-outline remove-wishlist-btn" 
                                                        data-wishlist-id="{{ $wishlist->id }}"
                                                        data-product-id="{{ $product->id }}">
                                                    <i class="fas fa-heart"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-wishlist text-center py-5">
                            <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                            <h4>Your wishlist is empty</h4>
                            <p class="text-muted">Save your favorite products for later by clicking the heart icon.</p>
                            <a href="{{ route('product.list') }}" class="btn btn-primary">Continue Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
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
                showNotification('Product added to cart successfully!', 'success');
                // Update button state
                $btn.text('Added to Cart').removeClass('btn-primary').addClass('btn-success');
                setTimeout(function() {
                    $btn.text('Add to Cart').removeClass('btn-success').addClass('btn-primary');
                }, 2000);
            } else {
                showNotification('Failed to add product to cart', 'error');
            }
        }).fail(function() {
            showNotification('Something went wrong. Please try again.', 'error');
        });
    });
    
    // Remove from wishlist
    $('.remove-wishlist-btn').click(function() {
        var $btn = $(this);
        var wishlistId = $btn.data('wishlist-id');
        var productId = $btn.data('product-id');
        var $wishlistItem = $btn.closest('.wishlist-item');
        
        if (confirm('Are you sure you want to remove this item from your wishlist?')) {
            $.ajax({
                url: '{{ route("wishlist.remove") }}',
                method: 'DELETE',
                data: {
                    wishlist_id: wishlistId,
                    product_id: productId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.message) {
                        showNotification(response.message, 'success');
                        $wishlistItem.fadeOut(300, function() {
                            $(this).remove();
                            // Check if wishlist is empty
                            if ($('.wishlist-item').length === 0) {
                                location.reload();
                            }
                        });
                    }
                },
                error: function() {
                    showNotification('Failed to remove item from wishlist', 'error');
                }
            });
        }
    });
    
    function updateCartCount() {
        $.get('{{ route("cart.count") }}', function(response) {
            $('#cart-count-badge').text(response.count).show();
        });
    }
    
    function showNotification(message, type = 'success') {
        // Create notification element
        var notification = $('<div class="notification alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
            message +
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
            '</div>');
        
        // Add to top of page
        $('body').prepend(notification);
        
        // Auto remove after 3 seconds
        setTimeout(function() {
            notification.fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }
});
</script>

<style>
.wishlist-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.wishlist-item {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.wishlist-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.wishlist-product {
    position: relative;
}

.product-image {
    position: relative;
    overflow: hidden;
    height: 200px;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-image:hover img {
    transform: scale(1.05);
}

.back-image {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-image:hover .back-image {
    opacity: 1;
}

.sale-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #dc3545;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
}

.product-info {
    padding: 1rem;
}

.product-info h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
    line-height: 1.4;
}

.product-info h4 a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.product-info h4 a:hover {
    color: #007bff;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.stars {
    display: flex;
    gap: 2px;
}

.stars i {
    color: #ffc107;
    font-size: 14px;
}

.stars i.filled {
    color: #ffc107;
}

.stars i:not(.filled) {
    color: #e0e0e0;
}

.product-rating span {
    color: #666;
    font-size: 14px;
}

.product-price {
    margin-bottom: 1rem;
}

.original-price {
    text-decoration: line-through;
    color: #999;
    font-size: 0.9rem;
    margin-right: 0.5rem;
}

.current-price {
    color: #333;
    font-weight: bold;
    font-size: 1.1rem;
}

.product-actions {
    display: flex;
    gap: 0.5rem;
}

.product-actions .btn {
    flex: 1;
    padding: 0.5rem;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-primary:hover {
    background: #0056b3;
}

.btn-outline {
    background: transparent;
    border: 1px solid #dc3545;
    color: #dc3545;
}

.btn-outline:hover {
    background: #dc3545;
    color: white;
}

.empty-wishlist {
    padding: 4rem 2rem;
    text-align: center;
}

.empty-wishlist i {
    color: #e0e0e0;
    margin-bottom: 1rem;
}

.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    min-width: 300px;
}

@media (max-width: 768px) {
    .wishlist-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
    }
    
    .product-actions {
        flex-direction: column;
    }
    
    .notification {
        left: 20px;
        right: 20px;
        min-width: auto;
    }
}
</style>

@include('front.layouts.footer')
