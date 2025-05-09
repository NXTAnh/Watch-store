<?php include("../inc/top.php"); ?>

<h4 class="text-info mb-4">
    <i class="fas fa-tachometer-alt"></i> Bảng điều khiển
</h4>

<?php
$isSearching = isset($_POST['id']) && !empty($_POST['id']);

if (!$isSearching) {
    $tongSoDon = count($dsdonhang);
    $tongDoanhThu = 0;
    foreach ($dsdonhang as $dh) {
        $tongDoanhThu += $dh["tongtien"];
    }
?>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-shopping-cart fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h6 class="text-primary mb-1">Tổng số đơn hàng</h6>
                        <div class="h5 font-weight-bold"><?php echo $tongSoDon; ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3 mt-md-0">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                    </div>
                    <div>
                        <h6 class="text-success mb-1">Tổng doanh thu</h6>
                        <div class="h5 font-weight-bold"><?php echo number_format($tongDoanhThu); ?>đ</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Form tìm kiếm -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form class="row g-2 align-items-center" method="post" action="index.php">
            <input type="hidden" name="action" value="timdonhang">
            
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" class="form-control" name="id" placeholder="🔍 Nhập ID đơn hàng..." required>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i> Tìm kiếm
                        </button>
                    </div>
                </div>
            </div>

            <?php if ($isSearching): ?>
                <div class="col-md-4 text-end">
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>


<!-- Bảng đơn hàng -->
<div class="table-responsive">
    <table class="table table-bordered table-hover shadow-sm">
        <thead class="thead-light">
            <tr>
                <th><i class="fas fa-hashtag"></i> ID</th>
                <th><i class="fas fa-map-marker-alt"></i> Địa chỉ</th>
                <th><i class="fas fa-calendar-alt"></i> Ngày tạo</th>
                <th><i class="fas fa-coins"></i> Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($dsdonhang) > 0): ?>
                <?php foreach ($dsdonhang as $dh): ?>
                    <tr>
                        <td><?php echo $dh["id"]; ?></td>
                        <td><?php echo htmlspecialchars($dh["diachi"]); ?></td>
                        <td><?php echo $dh["ngay"]; ?></td>
                        <td class="text-right text-success font-weight-bold"><?php echo number_format($dh["tongtien"]); ?>đ</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        <i class="fas fa-info-circle"></i> Không có đơn hàng nào.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include("../inc/bottom.php"); ?>
