@include('front.layouts.header')

<div class="main">
    <section class="product-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="sec-title text-start">
                        <h3 class="section-main-title">
                            Products
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form action="#" class="filter-form">
                        <div class="row align-items-center">
                            <div class="col-lg-7 col-md-6 col-6">
                                <div class="d-md-none text-start">
                                    <a href="javascript:void(0);" class="body-color" data-bs-toggle="offcanvas"
                                        data-bs-target="#mobileFilter" aria-controls="mobileFilter">
                                        <i class="fa-solid fa-sliders"></i> Filter and sort
                                    </a>
                                </div>
                                <div class="filter d-none d-md-flex">
                                    <div class="custom-dropdown">
                                        <p class="mb-0">Filter:</p>
                                        <p class="dropdown-toggle mb-0" id="category-toggle">Category</p>
                                        <div class="dropdown-menu">
                                            <div class="dropdown-header">
                                                <span class="selected-count">Category</span>
                                                <a href="javascript:void(0);" class="reset"
                                                    id="reset-category">Reset</a>
                                            </div>
                                            <div class="dropdown-options">
                                                <label><input type="radio" name="category_filter" value=""
                                                        {{ !$category_id ? 'checked' : '' }}> All Categories</label>
                                                @foreach ($categories as $cat)
                                                    <label><input type="radio" name="category_filter"
                                                            value="{{ $cat->id }}"
                                                            {{ $category_id == $cat->id ? 'checked' : '' }}>
                                                        {{ $cat->name }}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="custom-dropdown price">
                                        <p class="dropdown-toggle mb-0" id="price-toggle">Price</p>
                                        <div class="dropdown-menu">
                                            <div class="dropdown-header">
                                                <p id="price-range-text">Price Range</p>
                                                <a href="javascript:void(0);" class="reset" id="reset-price">Reset</a>
                                            </div>
                                            <div class="dropdown-options">
                                                <div class="price-input">
                                                    <span>₹ &nbsp;</span>
                                                    <div class="form-floating">
                                                        <input type="number" class="form-control from-price"
                                                            id="min_price" placeholder="From" min="0"
                                                            value="">
                                                        <label for="min_price">From</label>
                                                    </div>
                                                </div>
                                                <div class="price-input">
                                                    <span>₹ &nbsp;</span>
                                                    <div class="form-floating">
                                                        <input type="number" class="form-control to-price"
                                                            id="max_price" placeholder="To" min="0"
                                                            value="">
                                                        <label for="max_price">To</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-5 col-md-6 col-6">
                                <div class="filter  float-end">
                                    <div class="custom-select d-none d-md-flex">
                                        <label for="sort">Sort By:</label>
                                        <select name="sort" id="sort" class="custom-select-filter ms-2">
                                            <option value="manual"> Featured</option>
                                            <option value="best-selling"> Best selling</option>
                                            <option value="title-ascending" selected="selected"> Alphabetically, A-Z
                                            </option>
                                            <option value="title-descending">Alphabetically, Z-A</option>
                                            <option value="price-low-high">Price, low to high</option>
                                            <option value="price-high-low"> Price, high to low </option>
                                            <option value="whats-new">What's new</option>
                                            <option value="better-discount">Better discount</option>
                                        </select>
                                    </div>
                                    <p class="mb-0"><span id="product-count">{{ $products->total() }}</span> Products
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="product-list">
                <div class="row" id="products-row">
                    @forelse ($products as $index => $product)
                        @php
                            // Calculate final price with discount
                            if ($product->discount && $product->discount_type) {
                                if ($product->discount_type == 'percent') {
                                    $finalPrice = $product->price - ($product->price * $product->discount) / 100;
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
                            $backImage = $product->back_image
                                ? asset('product/' . $product->back_image)
                                : ($otherImages && count($otherImages) > 0
                                    ? asset('product/' . $otherImages[0])
                                    : asset('product/' . $product->image));
                            $mainImage = asset('product/' . $product->image);

                            // Delay class for animation
                            $delayClass = 'delay-' . (($index % 4) + 1) * 10;
                        @endphp
                        <div class="col-lg-3 col-md-6 col-6">
                            <div class="product animate-on-scroll slide-up {{ $delayClass }}">
                                <div class="pro-image">
                                    <a href="{{ route('product.detail', $product->id) }}">
                                        <img src="{{ $mainImage }}" alt="{{ $product->title }}" class="pro-1">
                                        <img src="{{ $backImage }}" alt="{{ $product->title }}" class="pro-2">
                                        @if ($hasDiscount)
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
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <li><i class="fa-solid fa-star"></i></li>
                                                    @endfor
                                                    <li><span>({{ $reviewCount }})</span></li>
                                                </ul>
                                                <div class="product-price">
                                                    @if ($hasDiscount)
                                                        <del> RS. {{ number_format($product->price, 2) }}</del>
                                                    @endif
                                                    <p>RS. {{ number_format($finalPrice, 2) }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-btn">
                                    <a href="{{ route('product.detail', $product->id) }}"
                                        class="btn ak-btn w-100 mb-2">Choose Options</a>
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
                    <div class="col-lg-12">
                        <div class="page-num">
                            {{ $products->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="offcanvas offcanvas-end" tabindex="-1" id="mobileFilter" aria-labelledby="mobileFilterLabel">
    <div class="offcanvas-header">
        <p id="mobileFilterLabel">Filter And Sort <br> <span id="mobile-product-count">{{ $products->total() }}
                Products</span> </p>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="p-4 pt-0 pb-0 filter-menu">
            <li class="list-unstyled py-2"><a href="javascript:void(0);" data-target="category"
                    class="text-dark d-flex justify-content-between">Category <i
                        class="fa-solid fa-arrow-right"></i></a></li>
            <li class="list-unstyled py-2"><a href="javascript:void(0);" data-target="price"
                    class="text-dark d-flex justify-content-between">Price <i class="fa-solid fa-arrow-right"></i></a>
            </li>
        </ul>
        <!-- same filter content reused for mobile -->
        <div class="custom-dropdown mb-4" data-option="category">
            <a href="javascript:void(0);" class="mb-3 text-dark back-btn d-block w-100"><i
                    class="fa-solid fa-arrow-left"></i> Category</a>
            <div class="dropdown-options">
                <label><input type="radio" name="category_filter_mobile" value="" class="me-1"
                        {{ !$category_id ? 'checked' : '' }}> All Categories</label><br>
                @foreach ($categories as $cat)
                    <label><input type="radio" name="category_filter_mobile" value="{{ $cat->id }}"
                            class="me-1" {{ $category_id == $cat->id ? 'checked' : '' }}>
                        {{ $cat->name }}</label><br>
                @endforeach
            </div>
        </div>

        <div class="custom-dropdown price " data-option="price">
            <a href="javascript:void(0);" class="mb-3 text-dark back-btn d-block w-100"><i
                    class="fa-solid fa-arrow-left"></i> Price</a>
            <div class="dropdown-options">
                <div class="price-input">
                    <span>₹ &nbsp;</span>
                    <div class="form-floating">
                        <input type="number" class="form-control from-price" id="min_price_mobile"
                            placeholder="From" min="0">
                        <label for="min_price_mobile">From</label>
                    </div>
                </div>
                <div class="price-input">
                    <span>₹ &nbsp;</span>
                    <div class="form-floating">
                        <input type="number" class="form-control to-price" id="max_price_mobile" placeholder="To"
                            min="0">
                        <label for="max_price_mobile">To</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="custom-select mb-4 p-4 pt-0">
            <label for="sortMobile">Sort By:</label>
            <select name="sort" id="sortMobile" class="custom-select-filter  ">
                <option value="manual">Featured</option>
                <option value="best-selling">Best selling</option>
                <option value="title-ascending" selected>Alphabetically, A-Z</option>
                <option value="title-descending">Alphabetically, Z-A</option>
                <option value="price-low-high">Price, low to high</option>
                <option value="price-high-low">Price, high to low</option>
                <option value="whats-new">What's new</option>
                <option value="better-discount">Better discount</option>
            </select>
        </div>
    </div>
</div>
@include('front.layouts.footer')
<script>
    $(document).ready(function() {
        // Filter functionality
        let filterTimeout;

        const applyFilters = function() {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(function() {
                const categoryId = $('input[name="category_filter"]:checked').val() || '';
                const minPrice = $('#min_price').val();
                const maxPrice = $('#max_price').val();
                const sortBy = $('#sort').val();

                // Update UI
                if (categoryId) {
                    const categoryName = $('input[name="category_filter"]:checked').closest('label')
                        .text().trim();
                    $('#category-toggle').text(categoryName);
                } else {
                    $('#category-toggle').text('Category');
                }

                if (minPrice || maxPrice) {
                    $('#price-range-text').text((minPrice ? '₹' + minPrice : 'Min') + ' - ' + (
                        maxPrice ? '₹' + maxPrice : 'Max'));
                } else {
                    $('#price-range-text').text('Price Range');
                }

                // Show loading
                $('#products-row').html(
                    '<div class="col-12 text-center py-5"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                    );

                $.ajax({
                    url: '{{ route('products.filter') }}',
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    data: {
                        category_id: categoryId || '',
                        min_price: minPrice || '',
                        max_price: maxPrice || '',
                        sort_by: sortBy || ''
                    },
                    success: function(response) {
                        console.log('Response:', response);
                        console.log('Products HTML length:', response.products ? response.products.length : 0);
                        if (response && response.products && response.products.trim() !== '') {
                            // Clear and set products
                            $('#products-row').empty();
                            $('#products-row').html(response.products);
                            
                            // Wait a bit for DOM to update
                            setTimeout(function() {
                                // Force reflow to ensure display
                                if ($('#products-row')[0]) {
                                    $('#products-row')[0].offsetHeight;
                                }
                                
                                // Show the products row if hidden
                                $('#products-row').show().css({
                                    'display': 'flex',
                                    'opacity': '1',
                                    'visibility': 'visible'
                                });
                                $('.product-list').show().css('display', 'block');
                                
                                // Make sure all product items are visible
                                $('#products-row .product').each(function() {
                                    $(this).css({
                                        'opacity': '1',
                                        'visibility': 'visible',
                                        'display': 'block'
                                    });
                                });
                                
                                // Remove any animation classes that might hide content
                                $('#products-row .product').removeClass('wow').removeAttr('data-wow-duration data-wow-delay');
                                
                                console.log('Products loaded and visible:', $('#products-row .product').length);
                                console.log('First product HTML:', $('#products-row .product').first().html().substring(0, 100));
                            }, 100);
                            
                            const totalProducts = response.debug_total || 0;
                            $('#product-count').text(totalProducts);
                            $('#mobile-product-count').text(totalProducts + ' Products');

                            // Update pagination
                            if (response.pageination && response.pageination.trim() !== '') {
                                $('.page-num').html(response.pageination);
                            } else {
                                $('.page-num').html('');
                            }
                        } else {
                            console.log('No products in response or empty HTML');
                            $('#products-row').html('<div class="col-12 text-center py-5"><p class="mb-0">No products found.</p></div>');
                        }
                        $('.dropdown-menu').hide();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr, status, error);
                        console.error('Response:', xhr.responseText);
                        $('#products-row').html('<div class="col-12 text-center py-5"><p class="text-danger">Error loading products. Please try again.</p></div>');
                    }
                });
            }, 500);
        };

        // Apply filters on change
        $(document).on('change', 'input[name="category_filter"]', function() {
            applyFilters();
        });

        $('#sort').on('change', applyFilters);

        $(document).on('blur', '#min_price, #max_price', function() {
            if ($(this).val()) {
                applyFilters();
            }
        });

        // Reset buttons
        $(document).on('click', '#reset-category', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('input[name="category_filter"][value=""]').prop('checked', true);
            $('#category-toggle').text('Category');
            applyFilters();
        });

        $(document).on('click', '#reset-price', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#min_price').val('');
            $('#max_price').val('');
            $('#price-range-text').text('Price Range');
            applyFilters();
        });

        // Mobile filters
        $('input[name="category_filter_mobile"]').on('change', function() {
            const categoryId = $(this).val();
            if (categoryId) {
                $('input[name="category_filter"][value="' + categoryId + '"]').prop('checked', true);
            } else {
                $('input[name="category_filter"][value=""]').prop('checked', true);
            }
            $('#category-toggle').text(categoryId ? $(this).closest('label').text().trim() :
            'Category');
            applyFilters();
        });

        $('#min_price_mobile, #max_price_mobile').on('blur', function() {
            $('#min_price').val($('#min_price_mobile').val());
            $('#max_price').val($('#max_price_mobile').val());
            applyFilters();
        });

        $('#sortMobile').on('change', function() {
            $('#sort').val($(this).val());
            applyFilters();
        });

        // Pagination
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (url) {
                const categoryId = $('input[name="category_filter"]:checked').val() || '';
                const minPrice = $('#min_price').val();
                const maxPrice = $('#max_price').val();
                const sortBy = $('#sort').val();

                const separator = url.includes('?') ? '&' : '?';
                const newUrl = url + separator + 'category_id=' + (categoryId || '') +
                    '&min_price=' + (minPrice || '') +
                    '&max_price=' + (maxPrice || '') +
                    '&sort_by=' + (sortBy || '');

                window.location.href = newUrl;
            }
        });
    });

    // Add to Cart functionality for product list and filtered products
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
</script>
