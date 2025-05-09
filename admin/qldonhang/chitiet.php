<?php include("../inc/top.php"); ?>

<div class="container mt-4">

    <!-- Tiêu đề đơn hàng -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-info">
            <i class="fas fa-receipt"></i> Chi tiết đơn hàng #<?php echo $_REQUEST["id"] ?>
        </h4>
        <a href="../qldonhang/index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay về danh sách
        </a>
    </div>

    <!-- Thông tin đơn hàng -->
    <div class="mb-3">
        <h6><i class="fas fa-calendar-alt"></i> Ngày tạo: <span class="text-muted"><?php echo $donhang['ngay'] ?></span></h6>
        <h6><i class="fas fa-coins"></i> Tổng tiền: 
            <span class="text-success fw-bold"><?php echo number_format($donhang['tongtien']) ?>đ</span>
        </h6>
    </div>

    <!-- Bảng chi tiết mặt hàng -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm">
            <thead class="table-light">
                <tr>
                    <th><i class="fas fa-box"></i> Tên mặt hàng</th>
                    <th><i class="fas fa-money-bill-wave"></i> Giá bán</th>
                    <th><i class="fas fa-sort-numeric-up"></i> Số lượng</th>
                    <th><i class="fas fa-image"></i> Hình ảnh</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dsmathang as $m): ?>
                    <tr>
                        <td>
                            <a href="../qlmathang/index.php?action=chitiet&id=<?php echo $m["id_mathang"]; ?>">
                                <?php echo htmlspecialchars($m["tenmathang"]); ?>
                            </a>
                        </td>
                        <td class="text-success"><?php echo number_format($m["giaban"]); ?>đ</td>
                        <td><?php echo number_format($m["soluong"]); ?></td>
                        <td>
                            <a href="../qlmathang/index.php?action=chitiet&id=<?php echo $m["id_mathang"]; ?>">
                                <img src="../../<?php echo $m["hinhanh"]; ?>" width="80" class="img-thumbnail" alt="Ảnh sản phẩm">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include("../inc/bottom.php"); ?>
