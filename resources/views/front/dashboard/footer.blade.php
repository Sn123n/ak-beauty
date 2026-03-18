    <footer class="footer dashboard">
        <div class="container">
            <div class="footer-bottom">
                <ul>
                    <li>
                        <a href="javascript:void(0);"  data-bs-toggle="modal" data-bs-target="#policy">Refund Policy</a>
                    </li>
                    <li>
                        <a href="">Shipping Policy</a>
                    </li>
                    <li>
                        <a href="">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="">Terms of Service</a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
    <div class="modal policy-modal fade" id="policy" tabindex="-1" aria-labelledby="policyLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="policyLabel">Add address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="policy-details">
                        <h5>Refund and Exchange Policy</h5>
                        <p>At AK Beauty store, we prioritize your satisfaction and strive to ensure a smooth shopping experience. We offer an exchange policy for items that are damaged or incorrectly received. If you encounter any issues with your order, please inspect your item upon reception and contact us immediately at akbeautystore@gmail.com.</p>
                        <h5>Exchange Conditions</h5>
                        <p>To be eligible for an exchange, you must request it within 72 hours of receiving your item. The item must be in the same condition that you received it, unworn or unused, with tags, and in its original packaging. Additionally, you will need the receipt or proof of purchase.</p>
                        <h5>How to Request an Exchange</h5>
                        <ol>
                            <li><p>Contact us at thr3estrokes@gmail.com within 72 hours of receiving your item. </p></li>
                            <li><p>Provide details of the issue and include a photo if the item is damaged. </p></li>
                            <li><p>If your exchange request is approved, we will send you a return shipping label and instructions on how and where to send your package.</p></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- Owl Carousel JS -->
    <script src="assets/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!-- Fancybox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
    <!-- PhotoSwipe JS -->
    <script src="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/photoswipe.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/photoswipe-lightbox.umd.min.js"></script>

    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/custom.js"></script>
    
    <!-- Toast Notification Container -->
    <div id="toast-notification" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 9999; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; padding: 15px 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); min-width: 300px; max-width: 400px; animation: slideInRight 0.3s ease-out;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <i class="fa-solid fa-check-circle" style="color: #28a745; font-size: 20px;"></i>
            <span id="toast-notification-message" style="color: #155724; font-size: 14px; font-weight: 500;"></span>
        </div>
    </div>
    
    <!-- Error Toast Notification Container -->
    <div id="toast-error-notification" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 9999; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; padding: 15px 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); min-width: 300px; max-width: 400px; animation: slideInRight 0.3s ease-out;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <i class="fa-solid fa-exclamation-circle" style="color: #dc3545; font-size: 20px;"></i>
            <span id="toast-error-message" style="color: #721c24; font-size: 14px; font-weight: 500;"></span>
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
        
        #toast-notification.show, #toast-error-notification.show {
            animation: slideInRight 0.3s ease-out;
        }
        
        #toast-notification.hide, #toast-error-notification.hide {
            animation: slideOutRight 0.3s ease-out;
        }
    </style>
    
    <script>
        // Global toast notification functions
        function showToast(message, type = 'success') {
            if (type === 'success') {
                const notification = $('#toast-notification');
                $('#toast-notification-message').text(message || 'Operation completed successfully!');
                $('#toast-error-notification').hide();
                notification.removeClass('hide').addClass('show').fadeIn(300);
                
                setTimeout(function() {
                    notification.removeClass('show').addClass('hide');
                    setTimeout(function() {
                        notification.fadeOut(300);
                    }, 300);
                }, 3000);
            } else {
                const notification = $('#toast-error-notification');
                $('#toast-error-message').text(message || 'Something went wrong!');
                $('#toast-notification').hide();
                notification.removeClass('hide').addClass('show').fadeIn(300);
                
                setTimeout(function() {
                    notification.removeClass('show').addClass('hide');
                    setTimeout(function() {
                        notification.fadeOut(300);
                    }, 300);
                }, 3000);
            }
        }
        
        // Make function globally available
        window.showToast = showToast;
    </script>
    
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const openIcon = document.getElementById('menuOpenIcon');
        const closeIcon = document.getElementById('menuCloseIcon');
        const closeBtn = document.getElementById('menuClose'); // optional '×' button inside menu

        // Toggle menu open/close
        menuToggle.addEventListener('click', () => {
        const isActive = mobileMenu.classList.toggle('active');

        if (isActive) {
            openIcon.classList.add('d-none');
            closeIcon.classList.remove('d-none');
        } else {
            openIcon.classList.remove('d-none');
            closeIcon.classList.add('d-none');
        }
        });

        // Close when inside button is clicked
        if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
            openIcon.classList.remove('d-none');
            closeIcon.classList.add('d-none');
        });
        }
    </script>


</body>
</html>
