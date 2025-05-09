<?php include("../inc/top.php"); ?>

<div class="container mt-4">
    <h3 class="text-info mb-3">
        <i class="fas fa-users"></i> Quản lý khách hàng
    </h3>

    <!-- Thông báo lỗi nếu có -->
    <?php if (isset($tb)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-exclamation-triangle"></i> Lỗi!</strong> <?php echo $tb; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    <?php endif; ?>

    <!-- Danh sách người dùng -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover shadow-sm">
            <thead class="table-light">
                <tr>
                    <th><i class="fas fa-envelope"></i> <a class="text-decoration-none" href="index.php?sort=email">Email</a></th>
                    <th><i class="fas fa-phone"></i> <a class="text-decoration-none" href="index.php?sort=sodienthoai">Số điện thoại</a></th>
                    <th><i class="fas fa-user"></i> <a class="text-decoration-none" href="index.php?sort=hoten">Họ tên</a></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nguoidung as $nd): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($nd["email"]); ?></td>
                        <td><?php echo htmlspecialchars($nd["sodienthoai"]); ?></td>
                        <td><?php echo htmlspecialchars($nd["hoten"]); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("../inc/bottom.php"); ?>
