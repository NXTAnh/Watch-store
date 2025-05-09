<?php include("../inc/top.php"); ?>

<h4 class="text-info">Quản lý doanh thu</h4>

<div class="d-flex gap-2">
    <div class="card text-white bg-success mb-3" style="width: 33.33%">
        <div class="card-body">
            <h5 class="card-title text-white">DOANH THU THEO NGÀY</h5>
            <p class="card-text h1 text-white"><?php echo number_format($tongdoanhthutheongay) ?>đ</p>
        </div>
    </div>
    <div class="card text-white bg-warning mb-3" style="width: 33.33%">
        <div class="card-body">
            <h5 class="card-title text-white">DOANH THU THEO THÁNG</h5>
            <p class="card-text h1 text-white"><?php echo number_format($tongdoanhthutheothang) ?>đ</p>
        </div>
    </div>
    <div class="card text-white bg-danger mb-3" style="width: 33.33%">
        <div class="card-body">
            <h5 class="card-title text-white">DOANH THU THEO NĂM</h5>
            <p class="card-text h1 text-white"><?php echo number_format($tongdoanhthutheonam) ?>đ</p>
        </div>
    </div>
</div>
<!-- Form lọc doanh thu -->
<form class="row g-3 mb-4 align-items-end" method="post" action="index.php">
    <input type="hidden" name="action" value="loc">

    <!-- Lọc theo ngày -->
    <div class="col-md-3">
        <label for="ngay" class="form-label">
            <i class="bi bi-calendar-date me-1 text-primary"></i> Ngày cụ thể
        </label>
        <input type="date" id="ngay" name="ngay" class="form-control">
    </div>

    <!-- Lọc theo tháng -->
    <div class="col-md-3">
        <label for="thang" class="form-label">
            <i class="bi bi-calendar-month me-1 text-warning"></i> Tháng cụ thể
        </label>
        <input type="month" id="thang" name="thang" class="form-control">
    </div>

    <!-- Lọc theo năm -->
    <div class="col-md-3">
        <label for="nam" class="form-label">
            <i class="bi bi-calendar3 me-1 text-danger"></i> Năm cụ thể
        </label>
        <input type="number" id="nam" name="nam" class="form-control" min="2000" max="<?= date("Y") ?>">
    </div>

    <!-- Nút lọc -->
    <div class="col-md-3">
        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-filter-circle me-1"></i> Lọc doanh thu
        </button>
    </div>
</form>


<!-- Biểu đồ doanh thu -->
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Biểu đồ doanh thu</h5>
        <canvas id="revenueChart" height="100"></canvas>
    </div>
</div>

<!-- Thêm Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Ngày', 'Tháng', 'Năm'],
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: [
                    <?php echo $tongdoanhthutheongay; ?>,
                    <?php echo $tongdoanhthutheothang; ?>,
                    <?php echo $tongdoanhthutheonam; ?>
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.7)',   // Green
                    'rgba(255, 193, 7, 0.7)',   // Yellow
                    'rgba(220, 53, 69, 0.7)'    // Red
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(220, 53, 69, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + 'đ';
                        }
                    }
                }
            }
        }
    });
</script>

<?php include("../inc/bottom.php"); ?>