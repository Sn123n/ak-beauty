@include('front.layouts.header')

<div class="main">
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="sec-title text-start">
            <h3 class="section-main-title animate-on-scroll slide-up delay-5">
              Track Your Order
            </h3>
          </div>
        </div>
      </div>

      <div class="track-order">
        <!-- Tabs for mobile view -->
        <ul class="nav nav-tabs" id="trackTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="order-tab" data-bs-toggle="tab" data-bs-target="#orderTab" type="button" role="tab">Order Number</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tracking-tab" data-bs-toggle="tab" data-bs-target="#trackingTab" type="button" role="tab">Tracking Number</button>
          </li>
        </ul>

        <!-- Tabs content -->
        <div class="tab-content mt-4" id="trackTabsContent">
          <!-- Order Number Tab -->
          <div class="tab-pane fade show active" id="orderTab" role="tabpanel">
            <form action="#">
              <div class="mb-3">
                <label for="">Order Number</label>
                <input type="text" class="form-control">
              </div>
              <div class="mb-3">
                <label for="">Email or Phone Number</label>
                <input type="text" class="form-control">
              </div>
              <button class="btn ak-btn ">Track</button>
            </form>
          </div>

          <!-- Tracking Number Tab -->
          <div class="tab-pane fade" id="trackingTab" role="tabpanel">
            <form action="#">
              <div class="mb-3">
                <label for="">Tracking Number</label>
                <input type="text" class="form-control">
              </div>
              <button class="btn ak-btn ">Track</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="container py-5 mt-5 mt-md-3">
      <div class="sec-title text-center tracked-order-title">
        <h3 class="section-main-title">
          Order #TS31379
        </h3>
      </div>

      <!-- Order Tracking -->
      <div class="tracker-container">
        <div class="progress-tracker">
          <div class="progress-line"></div>
          <div class="progress-line-active" id="progressActive"></div>

          <div class="step active">
            <div class="step-icon">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
              </svg>
            </div>
            <div class="step-dot"></div>
            <div>
              <div class="step-label">Ordered</div>
              <div class="step-date">Oct 29</div>
            </div>
          </div>

          <div class="step">
            <div class="step-icon">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 6h-3V4c0-1.1-.9-2-2-2H9c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM9 4h6v2H9V4zm11 16H4V8h16v12z" />
                <path d="M9 13h2v2H9zm4 0h2v2h-2z" />
              </svg>
            </div>
            <div class="step-dot"></div>
            <div>
            </div>
            <div class="step-label">Order Ready</div>
            <div class="step-date"></div>
          </div>

          <div class="step">
            <div class="step-icon">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 18.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.1.9-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z" />
              </svg>
            </div>
            <div class="step-dot"></div>
            <div>
              <div class="step-label">In Transit</div>
              <div class="step-date"></div>
            </div>
          </div>

          <div class="step">
            <div class="step-icon">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
              </svg>
            </div>
            <div class="step-dot"></div>
            <div>
              <div class="step-label">Out for Delivery</div>
              <div class="step-date"></div>
            </div>
          </div>

          <div class="step">
            <div class="step-icon">
              <i class="fa-regular fa-circle-check"></i>
            </div>
            <div class="step-dot"></div>
            <div>
              <div class="step-label">Delivered</div>
              <div class="step-date"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-lg-8">
          <!-- Status Section -->
          <div class="sec-title text-start tracked-order-title">
            <h3 class="section-main-title">Status: Ordered</h3>
            <h4 class="text-muted fw-normal">These items have not yet shipped.</h4>
          </div>
        </div>
        <div class="col-lg-4">
          <!-- Product Section -->
          <div class="product-card">
            <p class="text-muted">Product</p>
            <div class="track-product">
              <img src="assets/images/pro-3.jpg" alt="Product">
              <p>
                <a href="#">THR3E STROKES Spider Gel Kit: 2 Colors with Nail Art Brushes</a>
              </p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

@include('front.layouts.footer')
<script>
  window.addEventListener('load', function() {
    const progressActive = document.getElementById('progressActive');

    setTimeout(() => {
      if (window.innerWidth <= 768) {
        // =Animate height
        progressActive.style.height = '10%'; // Adjust as per active steps
      } else {
        // =Desktop: Animate width
        progressActive.style.width = '10%'; // Adjust as per active steps
      }
    }, 300);
  });

  // Optional: Recalculate on window resize (for responsive switching)
  window.addEventListener('resize', function() {
    const progressActive = document.getElementById('progressActive');

    if (window.innerWidth <= 768) {
      progressActive.style.width = '8px'; // reset horizontal width
      progressActive.style.height = '60%'; // adjust vertical
    } else {
      progressActive.style.height = '8px'; // reset vertical height
      progressActive.style.width = '60%'; // adjust horizontal
    }
  });
</script>
