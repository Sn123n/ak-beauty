    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Collections</h3>
                    <!-- Collections content would go here -->
                </div>

                <div class="footer-column">
                    <h3>Information</h3>
                    <ul>
                        <li><a href="javascript:void(0);">Search</a></li>
                        <li><a href="{{ route('user.privacypolicy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('user.refund_policy') }}">Refund Policy</a></li>
                        <li><a href="{{ route('user.term_condition') }}">Terms of Service</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="{{ route('index') }}">Home</a></li>
                        <li><a href="{{ route('product.list') }}">Shop All</a></li>
                        <li><a href="{{ route('user.aboutus') }}">About Us</a></li>
                        <li><a href="{{ route('user.contactus') }}">Contact Us</a></li>
                        <li><a href="{{ route('user.order') }}">Track Order</a></li>
                        <li><a href="{{ route('user.shipping_policy') }}">Shipping Policy</a></li>
                    </ul>
                </div>

                <div class="footer-column newsletter">
                    <h3>Subscribe To Our Emails</h3>
                    <p>Sign up to get the latest updates on sales, new releases and more..</p>
                    <form class="email-form">
                        <input type="email" class="email-input" placeholder="Email" required>
                        <button type="submit" class="submit-btn"></button>
                    </form>
                </div>
            </div>

            <div class="footer-bottom">
                © 2025, Ak BEAUTY SHOP
            </div>
        </div>
    </footer>
    <div class="offer-popup" id="offerPopup">
        <div class="offer-image">
            <img src="{{ asset('client_assets/images/pro-3.jpg') }}" alt="">
        </div>
        <div class="offer-content">
            <div class="w-100 text-end">
                <i class=" fa-solid fa-xmark" id="closeOffer"></i>
            </div>
            <h6>Someone form undefined added this product to their...</h6>
            <p>THR3E STROKES Spider Gel Kit: 2 Colors with Nail Art Brushes</p>
            <small>2 weeks ago</small>
        </div>
    </div>
    <script src="{{ asset('client_assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('client_assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Owl Carousel JS -->
    <script src="{{ asset('client_assets/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client_assets/js/slick.min.js') }}"></script>
    <!-- Fancybox JS -->
    <script src="{{ asset('client_assets/js/fancybox.umd.js') }}"></script>
    <script src="{{ asset('client_assets/js/flatpickr.js') }}"></script>
    <script src="{{ asset('client_assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('client_assets/js/custom.js') }}"></script>
    
    <!-- Success Notification Container -->
    <div id="cart-notification" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 9999; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; padding: 15px 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); min-width: 300px; max-width: 400px; animation: slideInRight 0.3s ease-out;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <i class="fa-solid fa-check-circle" style="color: #28a745; font-size: 20px;"></i>
            <span id="cart-notification-message" style="color: #155724; font-size: 14px; font-weight: 500;">Product added to cart successfully!</span>
        </div>
    </div>
    
    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        #cart-notification.show {
            animation: slideInRight 0.3s ease-out;
        }
        
        #cart-notification.hide {
            animation: slideOutRight 0.3s ease-out;
        }
    </style>
    
    <script>
        // Global notification function
        function showCartNotification(message) {
            const notification = $('#cart-notification');
            const messageSpan = $('#cart-notification-message');
            
            messageSpan.text(message || 'Product added to cart successfully!');
            notification.removeClass('hide').addClass('show').fadeIn(300);
            
            // Hide after 3 seconds
            setTimeout(function() {
                notification.removeClass('show').addClass('hide');
                setTimeout(function() {
                    notification.fadeOut(300);
                }, 300);
            }, 3000);
        }

        // Function to update cart count badge
        function updateCartCount() {
            $.get('{{ route("cart.count") }}', function(data) {
                const cartBadge = $('#cart-count-badge');
                const count = parseInt(data.count) || 0;
                
                if (count > 0) {
                    cartBadge.text(count).show();
                } else {
                    cartBadge.hide();
                }
            }).fail(function() {
                // If request fails, hide the badge
                $('#cart-count-badge').hide();
            });
        }

        // Update cart count on page load
        $(document).ready(function() {
            updateCartCount();
        });
    </script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const popup = document.getElementById('offerPopup');
        const closeBtn = document.getElementById('closeOffer');
        let popupTimeout;
        let popupInterval;
        let isClosed = false; // track if user closed manually

        function showPopup() {
            if (isClosed) return; // do nothing if user closed it
            popup.classList.add('show');

            // hide after 8s
            popupTimeout = setTimeout(() => {
                popup.classList.remove('show');
            }, 8000);
        }

        // Start first popup after 2s
        setTimeout(showPopup, 2000);

        // Repeat every 13s (8s visible + 5s hidden)
        popupInterval = setInterval(() => {
            if (!popup.classList.contains('show') && !isClosed) {
                showPopup();
            }
        }, 16000);

        // Close button click
        closeBtn.addEventListener('click', () => {
            popup.classList.remove('show');
            clearTimeout(popupTimeout);
            clearInterval(popupInterval);
            isClosed = true; // permanently stop reappearing
        });
    });
</script>


</body>
</html>

