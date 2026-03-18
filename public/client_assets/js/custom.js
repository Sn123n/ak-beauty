$(document).ready(function(){
  // Counter update
  $('.home-carousel').on('init reInit afterChange', function(event, slick, currentSlide, nextSlide){
    var i = (currentSlide ? currentSlide : 0) + 1;
    $('.slick-counter').text(i + '/' + slick.slideCount);
  });

  // Initialize slick
  $('.home-carousel').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    infinite: true,
    arrows: true, 
    dots: false,
    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
    responsive: [
      {
        breakpoint: 1024, // tablet
        settings: {
          slidesToShow: 1
        }
      },
      {
        breakpoint: 600, // mobile
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });
});

$(document).ready(function(){
  $(".product-carousel").owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    dots: true,
    dotsData: true, // enable thumbnail dots
    items: 1
  });
});


new WOW().init();

const observers = document.querySelectorAll('.animate-on-scroll');

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('show'); // trigger animation
    }
  });
});

observers.forEach(el => observer.observe(el));

// Select trending products
const trendingProducts = document.querySelectorAll('.trending-product.animate-trending');

// Create a separate IntersectionObserver for trending products
const trendingObserver = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      trendingProducts.forEach((prod, index) => {
        prod.style.animationDelay = `${0.5 + index * 0.15}s`; // staggered delay
        prod.classList.add('show'); // trigger animation
      });
      trendingObserver.disconnect(); // stop observing once triggered
    }
  });
}, { threshold: 0.1 });

// Observe each trending product
trendingProducts.forEach(prod => trendingObserver.observe(prod));

// header

let lastScrollTop = 0;
const header = document.getElementById('site-header');

if (header) {
  window.addEventListener('scroll', function() {
    let currentScroll = window.pageYOffset || document.documentElement.scrollTop;

    // Only trigger after 250px scroll
    if (currentScroll > 250) {
      if (currentScroll > lastScrollTop) {
        // Scrolling down
        if (!header.classList.contains('scroll-down')) {
          header.classList.remove('scroll-up');
          header.classList.add('scroll-down');
        }
      } else {
        // Scrolling up
        if (!header.classList.contains('scroll-up')) {
          header.classList.remove('scroll-down');
          header.classList.add('scroll-up');
        }
      }
    } else {
      // Before 250px scroll → remove both classes
      header.classList.remove('scroll-up', 'scroll-down');
    }

    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
  });
}

// slick slider
$(document).ready(function(){
  // Main slider
  $('.product-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    infinite: false
  });

  // Thumbnail slider
  $('.product-nav').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    dots: false,
    focusOnSelect: true,
    arrows: true,
    infinite: false,
    prevArrow: '<button type="button" class="slick-prev"><i class="fa-solid fa-chevron-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fa-solid fa-chevron-right"></i></button>',
    responsive: [
      {
        breakpoint: 1024, // tablet
        settings: {
          slidesToShow: 2,
          arrows: true
        }
      },{
        breakpoint: 600, // mobile
        settings: {
          slidesToShow: 0,
          arrows: true
        }
      }
    ]
  });

  // Change main image only on thumbnail click
  $('.product-nav .slick-slide').on('click', function(e){
    e.preventDefault();
    var index = $(this).data('slick-index');
    $('.product-for').slick('slickGoTo', index);
  });
});
$(document).ready(function(){
  $('.pro-home').on('init reInit afterChange', function(event, slick, currentSlide, nextSlide){
    var i = (currentSlide ? currentSlide : 0) + 1;
    $('.slick-counter').text(i + '/' + slick.slideCount);
  });

$('.pro-home').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    infinite: false,
    arrows: true, 
    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
    responsive: [
      {
        breakpoint: 1024, // tablet
        settings: {
          slidesToShow: 2.2,
          arrows: true
        }
      },
      {
        breakpoint: 600, // mobile
        settings: {
          slidesToShow: 2.3,
          arrows: true
        }
      }
    ]
  });
});
$(document).ready(function(){
  $('.s-product').on('init reInit afterChange', function(event, slick, currentSlide, nextSlide){
    var i = (currentSlide ? currentSlide : 0) + 1;
    $('.slick-counter').text(i + '/' + slick.slideCount);
  });

$('.s-product').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    infinite: false,
    arrows: true, 
    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
    responsive: [
      {
        breakpoint: 1024, // tablet
        settings: {
          slidesToShow: 2,
          arrows: true
        }
      },
      {
        breakpoint: 600, // mobile
        settings: {
          slidesToShow: 1.03,
          arrows: true
        }
      }
    ]
  });
});
$(document).ready(function(){
  $('.service-slider').on('init reInit afterChange', function(event, slick, currentSlide, nextSlide){
    var i = (currentSlide ? currentSlide : 0) + 1;
    $('.slick-counter').text(i + '/' + slick.slideCount);
  });

$('.service-slider').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    infinite: false,
    arrows: true, 
    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
    responsive: [
      {
        breakpoint: 1024, // tablet
        settings: {
          slidesToShow: 2,
          arrows: true
        }
      },
      {
        breakpoint: 600, // mobile
        settings: {
          slidesToShow: 1,
          arrows: true
        }
      }
    ]
  });
});

// qty
$(document).ready(function() {
  function updateButtons($input) {
    var val = parseInt($input.val());
    $input.siblings('.minus').prop('disabled', val <= 1); // disable minus if 1
  }

  // Initialize buttons on page load
  $('.qty-input').each(function() {
    updateButtons($(this));
  });

  // Plus button click
  $('.qty-btn.plus').click(function() {
    var $input = $(this).siblings('.qty-input');
    var val = parseInt($input.val());
    $input.val(val + 1);
    updateButtons($input);
  });

  // Minus button click
  $('.qty-btn.minus').click(function() {
    var $input = $(this).siblings('.qty-input');
    var val = parseInt($input.val());
    if (val > 1) $input.val(val - 1);
    updateButtons($input);
  });
});

// custom drop down
document.addEventListener("DOMContentLoaded", function () {
  // Select only dropdowns that actually have a .dropdown-toggle inside
  const dropdowns = document.querySelectorAll('.custom-dropdown:has(.dropdown-toggle)');

  dropdowns.forEach(dropdown => {
    const toggle = dropdown.querySelector('.dropdown-toggle');
    const menu = dropdown.querySelector('.dropdown-menu');
    const checkboxes = dropdown.querySelectorAll('input[type="checkbox"]');
    const selectedCount = dropdown.querySelector('.selected-count');
    const resetBtn = dropdown.querySelector('.reset');
    const fromPrice = dropdown.querySelector('.from-price');
    const toPrice = dropdown.querySelector('.to-price');

    // Toggle dropdown - only if toggle exists
    if (toggle) {
      toggle.addEventListener('click', (e) => {
        e.stopPropagation();

        // Close other dropdowns
        dropdowns.forEach(d => {
          if (d !== dropdown) {
            const otherMenu = d.querySelector('.dropdown-menu');
            if (otherMenu) otherMenu.style.display = 'none';
          }
        });

        if (menu) {
          menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
        }
      });
    }

    // Handle checkboxes (if exist)
    if (checkboxes.length && selectedCount) {
      checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
          const count = Array.from(checkboxes).filter(i => i.checked).length;
          selectedCount.textContent = `${count} selected`;
        });
      });
    }

    // Handle reset button
    if (resetBtn) {
      resetBtn.addEventListener('click', (e) => {
        e.preventDefault();

        if (checkboxes.length && selectedCount) {
          checkboxes.forEach(cb => cb.checked = false);
          selectedCount.textContent = '0 selected';
        }

        if (fromPrice && toPrice) {
          fromPrice.value = '';
          toPrice.value = '';
        }
      });
    }
  });

  // Close dropdown when clicking outside
  document.addEventListener('click', (e) => {
    dropdowns.forEach(dropdown => {
      if (!dropdown.contains(e.target)) {
        const menu = dropdown.querySelector('.dropdown-menu');
        if (menu) menu.style.display = 'none';
      }
    });
  });

  // Navbar toggle icon logic (unchanged)
  const toggler = document.querySelector(".navbar-toggler");
  if (toggler) {
    const iconBars = toggler.querySelector(".fa-bars");
    const iconClose = toggler.querySelector(".fa-xmark");

    if (iconBars && iconClose) {
      toggler.addEventListener("click", function () {
        iconBars.classList.toggle("d-none");
        iconClose.classList.toggle("d-none");
      });
    }
  }
});
 
// product mobile filter
$(document).ready(function() {
  $('.filter-menu a').on('click', function() {
    const target = $(this).data('target');

    $('.custom-dropdown').removeClass('active');

    $('.custom-dropdown[data-option="' + target + '"]').addClass('active');
  });

  $('.custom-dropdown .back-btn').on('click', function() {
    $(this).closest('.custom-dropdown').removeClass('active');
  });
});

// search 
const searchToggle = document.getElementById('search-toggle');
const searchBox = document.getElementById('search-box');
const body = document.body;
const closeSearch = document.getElementById('close_search');

// Toggle search on icon click - only if elements exist
if (searchToggle && searchBox) {
  searchToggle.addEventListener('click', () => {
    searchBox.classList.toggle('active');
    body.classList.toggle('shadow');
  });

  // Close when clicking outside
  document.addEventListener('click', (e) => {
    if (!searchBox.contains(e.target) && !searchToggle.contains(e.target)) {
      searchBox.classList.remove('active');
      body.classList.remove('shadow');
    }
  });
}

// Close when clicking the X icon - only if elements exist
if (closeSearch && searchBox) {
  closeSearch.addEventListener('click', () => {
    searchBox.classList.remove('active');
    body.classList.remove('shadow');
  });
}


// Initialize flatpickr only if element exists
const flatDatePicker = document.getElementById('flatDatePicker');
if (flatDatePicker && typeof flatpickr !== 'undefined') {
  flatpickr("#flatDatePicker", {
    // Optional configuration options
    enableTime: true, // Enables time selection in addition to date
    dateFormat: "m-y"
  });
}