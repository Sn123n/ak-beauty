<!-- Sidebar -left -->


<div class="h-100" id="leftside-menu-container" data-simplebar>

    <!--- Sidemenu -->

    <ul class="side-nav">

        <li class="side-nav-item">

            <a href="{{ route('dashboard') }}" class="side-nav-link">

                <i class="fa-solid fa-gauge-high"></i>

                <span> Dashboard </span>

            </a>

        </li>
        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarPages6" aria-expanded="false" aria-controls="sidebarPages6"
                class="side-nav-link">
                <i class="fa-solid fa-house"></i>
                <span> Home </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarPages6">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('sliders.index') }}">Slider</a>
                    </li>
                    <li>
                        <a href="{{ route('get-inspired.create') }}">Get Inspired</a>
                    </li>
                    <li>
                        <a href="{{ route('home-product.create') }}">French Manicure Kit</a>
                    </li>
                    <li>
                        <a href="{{ route('nailextenation') }}">Nail Extensions</a>
                    </li>
                    <li>
                        <a href="{{ route('footer-icon.index') }}">Manage FooterIcon</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarPages1" aria-expanded="false" aria-controls="sidebarPages"
                class="side-nav-link">
                <i class="fa-solid fa-user"></i>
                <span> Users </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarPages1">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('users.create') }}">Add User</a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}">Manage Users</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarPages3" aria-expanded="false" aria-controls="sidebarPages"
                class="side-nav-link">
                <i class="fa-brands fa-product-hunt"></i>
                <span> Product </span>
                <span class="menu-arrow"></span>
            </a>

            <div class="collapse" id="sidebarPages3">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('products.create') }}">Add Product</a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}">Manage Product</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarPages2" aria-expanded="false" aria-controls="sidebarPages"
                class="side-nav-link">
                <i class="fa-solid fa-list"></i>
                <span>Product Category </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarPages2">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('categories.create') }}">Add Category</a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}">Manage Category</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="side-nav-item">
            <a href="{{ route('order_list') }}" class="side-nav-link">
                <i class="fa-solid fa-file-lines"></i>
                <span> Order List </span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="{{ route('wishlist') }}" class="side-nav-link">
                <i class="fa-solid fa-heart"></i>
                <span> Wishlist </span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="{{ route('review.list') }}" class="side-nav-link">
                <i class="fa-solid fa-star"></i>
                <span> Product Review</span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="{{ route('notifications.index') }}" class="side-nav-link">
                <i class="fa-solid fa-bell"></i>
                <span> Notification</span>
            </a>
        </li>

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarPages15" aria-expanded="false" aria-controls="sidebarPages"
                class="side-nav-link">
                <i class="fa-solid fa-gift"></i>
                <span> Coupon </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarPages15">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('coupons.create') }}">Add Coupon</a>
                    </li>
                    <li>
                        <a href="{{ route('coupons.index') }}">Manage Coupon</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarPages10" aria-expanded="false" aria-controls="sidebarPages10"
                class="side-nav-link">
                <i class="fa-solid fa-file-lines"></i>
                <span> CMS Page </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarPages10">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('aboutus') }}">About Us</a>
                    </li>
                    <li>
                        <a href="{{ route('term_condition') }}">Terms & Condition</a>
                    </li>

                    <li>
                        <a href="{{ route('privacypolicy') }}">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="{{ route('shippingpolicy') }}">Shipping Policy</a>
                    </li>
                    <li>
                        <a href="{{ route('refundpolicy') }}">Refund Policy</a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('banners.index') }}">Manage Banner</a>
                    </li> --}}
                </ul>
            </div>
        </li>

        {{-- <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarPages7" aria-expanded="false" aria-controls="sidebarPages"
                class="side-nav-link">
                <i class="fa-brands fa-blogger"></i>
                <span> Blog </span>
                <span class="menu-arrow"></span>
            </a>

            <div class="collapse" id="sidebarPages7">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('blogs.create') }}">Add Blog</a>
                    </li>
                    <li>
                        <a href="{{ route('blogs.index') }}">Manage Blog</a>
                    </li>
                    <li>
                        <a href="{{ route('blog-category.index') }}">Manage BlogCategory</a>
                    </li>
                </ul>
            </div>
        </li> --}}

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarlocation" aria-expanded="false"
                aria-controls="sidebarlocation" class="side-nav-link">
                <i class="fa-solid fa-location-dot"></i>
                <span> Location </span>
                <span class="menu-arrow"></span>
            </a>

            <div class="collapse" id="sidebarlocation">
                <ul class="side-nav-second-level">
                    <li>
                        <a data-bs-toggle="collapse" href="#sidebarcountry" aria-expanded="false"
                            aria-controls="sidebarcountry">
                            Country <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarcountry">
                            <ul class="side-nav-third-level">
                                <li><a href="{{ route('countries.create') }}">Add Country</a></li>
                                <li><a href="{{ route('countries.index') }}">Manage Country</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-bs-toggle="collapse" href="#sidebarstate" aria-expanded="false"
                            aria-controls="sidebarstate">
                            State <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarstate">
                            <ul class="side-nav-third-level">
                                <li><a href="{{ route('state.create') }}">Add State</a></li>
                                <li><a href="{{ route('state.index') }}">Manage State</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-bs-toggle="collapse" href="#sidebarcity" aria-expanded="false"
                            aria-controls="sidebarcity">
                            City <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarcity">
                            <ul class="side-nav-third-level">
                                <li><a href="{{ route('cities.create') }}">Add City</a></li>
                                <li><a href="{{ route('cities.index') }}">Manage City</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-bs-toggle="collapse" href="#pincodesidebar" aria-expanded="false"
                            aria-controls="pincodesidebar">
                            Pincode <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="pincodesidebar">
                            <ul class="side-nav-third-level">
                                <li><a href="{{ route('pincode.create') }}">Add Pincode</a></li>
                                <li><a href="{{ route('pincode.index') }}">Manage Pincode</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </li>


        <li class="side-nav-item">
            <a href="{{ route('contactus') }}" class="side-nav-link">
                <i class="fa-solid fa-address-book"></i>
                <span>Contact Inquiry</span>
            </a>
        </li>

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarPages5" aria-expanded="false" aria-controls="sidebarPages"
                class="side-nav-link">
                <i class="fa-solid fa-clipboard"></i>
                <span> Testimonial </span>
                <span class="menu-arrow"></span>
            </a>

            <div class="collapse" id="sidebarPages5">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('testimonial.create') }}">Add Testimonial</a>
                    </li>
                    <li>
                        <a href="{{ route('testimonial.index') }}">Manage Testimonial</a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarPages4" aria-expanded="false" aria-controls="sidebarPages"
                class="side-nav-link">
                <i class="fa-solid fa-scroll"></i>
                <span> Advertise </span>
                <span class="menu-arrow"></span>
            </a>

            <div class="collapse" id="sidebarPages4">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('advertise.create') }}">Add Advertise</a>
                    </li>
                    <li>
                        <a href="{{ route('advertise.index') }}">Manage Advertise</a>
                    </li>
                </ul>
            </div>
        </li> --}}

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarPages2" aria-expanded="false" aria-controls="sidebarPages"
                class="side-nav-link">
                <i class="fa-solid fa-cloud"></i>
                <span>SEO </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarPages2">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('seo.create') }}">Add SEO</a>
                    </li>
                    <li>

                        <a href="{{ route('seo.index') }}">Manage SEO</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarPages8" aria-expanded="false" aria-controls="sidebarPages8"
                class="side-nav-link">
                <i class="fa-solid fa-gear"></i>
                <span> Setting </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarPages8">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('basicinfo') }}">Basic Info</a>
                    </li>
                    <li>
                        <a href="{{ route('edit.profile') }}">Edit Profile</a>
                    </li>
                    <li>
                        <a href="{{ route('reset.password') }}">Reset Password</a>
                    </li>
                </ul>
            </div>

        </li>

    </ul>

    <!--- End Sidemenu -->



    <div class="clearfix"></div>

</div>
