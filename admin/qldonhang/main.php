<?php include("../inc/top.php"); ?>

<div class="container mt-4">

    <!-- Form lọc theo ngày -->
    <form method="get" class="mb-4">
        <input type="hidden" name="action" value="macdinh">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-center text-primary">
                            <i class="fas fa-filter"></i> Lọc đơn hàng theo ngày
                        </h5>
                        <div class="form-group mb-3">
                            <label for="ngay"><strong><i class="fas fa-calendar-alt"></i> Chọn ngày:</strong></label>
                            <input type="date" class="form-control" name="ngay" id="ngay"
                                value="<?= isset($_GET['ngay']) ? $_GET['ngay'] : '' ?>">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Lọc đơn hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Bảng danh sách đơn hàng -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm">
            <thead class="table-light text-center">
                <tr>
                    <th><i class="fas fa-hashtag"></i> ID</th>
                    <th><i class="fas fa-user"></i> Khách hàng</th>
                    <th><i class="fas fa-map-marker-alt"></i> Địa chỉ</th>
                    <th><i class="fas fa-calendar-day"></i> Ngày tạo</th>
                    <th><i class="fas fa-coins"></i> Tổng tiền</th>
                    <th><i class="fas fa-eye"></i> Chi tiết</th>
                    <th><i class="fas fa-trash-alt"></i> Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dsdonhang as $dh): ?>
                    <tr>
                        <td class="text-center"><?= $dh["id"]; ?></td>
                        <td><?= htmlspecialchars($dh["tenkh"]); ?></td>
                        <td><?= htmlspecialchars($dh["diachi"]); ?></td>
                        <td><?= $dh["ngay"]; ?></td>
                        <td class="text-success fw-bold"><?= number_format($dh["tongtien"]); ?>đ</td>
                        <td class="text-center">
                            <a class="btn btn-info btn-sm" href="index.php?action=chitiet&id=<?= $dh["id"]; ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-danger btn-sm" href="index.php?action=xoa&id=<?= $dh["id"]; ?>"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?');">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include("../inc/bottom.php"); ?>
