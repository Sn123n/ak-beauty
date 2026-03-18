@include('front.dashboard.header')
<div class="main dashboard">
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-6">
                    <div class="sec-title text-start">
                        <h3 class="section-main-title">
                            Orders
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-6">
                    <div class="d-flex float-end gap-2">
                        <div class="custom-select d-none d-md-flex order-list-change ">
                            <div class="dropdown custom-select-filter">
                                <button class="btn btn-light dropdown-toggle d-flex align-items-center w-100" type="button" id="viewDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-th-large me-2"></i> Gallery
                                </button>
                                <ul class="dropdown-menu p-2" aria-labelledby="viewDropdown">
                                    <li class="active  rounded-3">
                                        <a class="dropdown-item text-gray d-flex align-items-center rounded-3" href="#" onclick="setView('gallery')">
                                            <i class="fas fa-th-large me-2"></i> Gallery <i class="fa-solid fa-check ms-auto"></i>
                                        </a>
                                    </li>
                                    <li class=" rounded-3">
                                        <a class="dropdown-item text-gray d-flex align-items-center rounded-3" href="#" onclick="setView('list')">
                                            <i class="fas fa-list-ul me-2"></i> List
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="order-filter" class="pointer"  data-bs-toggle="offcanvas" data-bs-target="#orderlist" aria-controls="orderlist">
                            <a href="javascript:void">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="order-card pointer"  data-href="order-details.php">
                        <a href="javascript:void(0);">
                            <div class="order-status d-flex align-items-center justify-content-between">
                                <div class="status">
                                    <i class="fa-solid fa-check me-2 mt-1"></i>
                                    <span class="fw-semibold d-flex flex-column">
                                        Confirmed
                                        <small class="text-muted ">Oct 12</small>
                                    </span>
                                </div>
                            </div>

                            <div class="order-image text-center mt-3">
                                <img src="assets/images/pro-3.jpg" alt="Product" class="img-fluid rounded">
                            </div>

                            <div class="order-details mt-3">
                                <p class=""><strong>1 item</strong></p>
                                <p class="text-muted">Order<span>#TS31377</span></p>
                                <h6 class="">₹599.00 INR</h6>
                            </div>

                            <div class="text-center">
                                <button class="btn ak-outline-btn w-100 ">Buy again</button>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table dash-order-list">
                        <thead>
                            <tr>
                                <th class="order-img"></th>
                                <th class="order-id">Order ID</th>
                                <th>Status</th>
                                <th class="order-total">Total</th>
                                <th class="order-again"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-href="order-details.php" class="pointer">
                                <td><img src="assets/images/pro-3.jpg" alt=""></td>
                                <td class="order-id">
                                    <p>#TS31377</p>
                                    <small>1 item</small>
                                </td>
                                <td class="status">
                                    <p>Confirmed</p>
                                    <small>Oct 12</small>
                                </td>
                                <td>₹599.00 INR</td>
                                <td>
                                    <a href="javascript:void(0);" class="table-toggle">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </a>
                                    <div class="table-drop">
                                        <a href="javascript:void(0);">Buy again</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>
</div>
<div class="offcanvas offcanvas-end order-filter-canvas" tabindex="-1" id="orderlist" aria-labelledby="orderlistLabel">
    <div class="offcanvas-header">
       <ul class="nav nav-pills" id="sortFilter" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="ord-sort-tab" data-bs-toggle="pill" data-bs-target="#ord-sort" type="button" role="tab" aria-controls="ord-sort" aria-selected="true">Sort</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="ord-filter-tab" data-bs-toggle="pill" data-bs-target="#ord-filter" type="button" role="tab" aria-controls="ord-filter" aria-selected="false">Filter</button>
            </li>
        </ul>
    </div>
    <div class="offcanvas-body">
        <!-- Sort Options -->
        <div class="tab-content" id="sortFilterContent">
            <div class="tab-pane fade show active" id="ord-sort" role="tabpanel" aria-labelledby="ord-sort-tab" tabindex="0">
                <form>
                    <div class="form-check mb-2">
                        <input class="form-check-input mt-2" type="radio" name="sortOption" id="newestOldest" checked>
                        <label class="form-check-label" for="newestOldest">
                            Newest to oldest
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input  mt-2" type="radio" name="sortOption" id="oldestNewest">
                        <label class="form-check-label" for="oldestNewest">
                            Oldest to newest
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input  mt-2" type="radio" name="sortOption" id="orderNumberHighLow">
                        <label class="form-check-label" for="orderNumberHighLow">
                            Order number (high to low)
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input  mt-2" type="radio" name="sortOption" id="orderNumberLowHigh">
                        <label class="form-check-label" for="orderNumberLowHigh">
                            Order number (low to high)
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input  mt-2" type="radio" name="sortOption" id="orderTotalHighLow">
                        <label class="form-check-label" for="orderTotalHighLow">
                            Order total (high to low)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input  mt-2" type="radio" name="sortOption" id="orderTotalLowHigh">
                        <label class="form-check-label" for="orderTotalLowHigh">
                            Order total (low to high)
                        </label>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade ord-filter" id="ord-filter" role="tabpanel" aria-labelledby="ord-filter-tab" tabindex="0">
                <p>Order date</p>
                <form>
                    <div class="form-check mb-2">
                        <input class="form-check-input mt-2" type="radio" name="sortOption" id="newestOldest" checked>
                        <label class="form-check-label" for="newestOldest">
                            Today
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input  mt-2" type="radio" name="sortOption" id="oldestNewest">
                        <label class="form-check-label" for="oldestNewest">
                            Last 7 days
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input  mt-2" type="radio" name="sortOption" id="orderNumberHighLow">
                        <label class="form-check-label" for="orderNumberHighLow">
                            Last 30 days
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input  mt-2" type="radio" name="sortOption" id="orderNumberLowHigh">
                        <label class="form-check-label" for="orderNumberLowHigh">
                            Last 90 days
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input  mt-2" type="radio" name="sortOption" id="orderTotalHighLow">
                        <label class="form-check-label" for="orderTotalHighLow">
                            Last 12 months
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input  mt-2" type="radio" name="sortOption" id="orderTotalLowHigh">
                        <label class="form-check-label" for="orderTotalLowHigh">
                            Custom
                        </label>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <a href="javascipt:void(0);" >Clear all</a>
        <button class="btn ak-btn" type="button">Apply</button>
    </div>
</div>
@include('front.dashboard.footer')

<script>
    function setView(view) {
        const button = document.getElementById('viewDropdown');
        if (view === 'gallery') {
            button.innerHTML = '<i class="fas fa-th-large me-2"></i> Gallery';
        } else {
            button.innerHTML = '<i class="fas fa-list-ul me-2"></i> List';
        }
    }
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rows = document.querySelectorAll('.dash-order-list tbody tr');
    const toggles = document.querySelectorAll('.table-toggle');

    rows.forEach(row => {
        row.addEventListener('click', function (e) {
            // Prevent redirect if click is on toggle or dropdown
            if (e.target.closest('.table-toggle') || e.target.closest('.table-drop')) return;

            const href = this.dataset.href;
            if (href) window.location.href = href;
        });
    });

    toggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.stopPropagation(); // stop from triggering row click

            const currentDrop = this.nextElementSibling;

            // close all other dropdowns
            document.querySelectorAll('.table-drop').forEach(drop => {
                if (drop !== currentDrop) drop.style.display = 'none';
            });

            // toggle current dropdown
            currentDrop.style.display = currentDrop.style.display === 'block' ? 'none' : 'block';
        });
    });

    // close dropdown if clicked outside
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.table-drop') && !e.target.closest('.table-toggle')) {
            document.querySelectorAll('.table-drop').forEach(drop => {
                drop.style.display = 'none';
            });
        }
    });
});

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Make the entire card clickable
    document.querySelectorAll('.order-card').forEach(card => {
        card.addEventListener('click', function() {
        const href = this.dataset.href;
        if (href) window.location.href = href;
        });
    });
});
</script>
