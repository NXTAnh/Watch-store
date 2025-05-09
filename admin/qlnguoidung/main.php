<?php include("../inc/top.php"); ?>

<div>
  <h3 class="mb-4 text-primary">
    <i class="fas fa-users-cog"></i> Quản lý người dùng
  </h3>

  <!-- Thông báo lỗi -->
  <?php if (isset($tb)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="fas fa-exclamation-triangle"></i> <strong>Lỗi!</strong> <?php echo $tb; ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php endif; ?>

  <!-- Nút thêm người dùng -->
  <div class="mb-3">
    <a class="btn btn-success" href="index.php?action=them">
      <i class="fas fa-user-plus"></i> Thêm người dùng
    </a>
  </div>

  <!-- Danh sách người dùng -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover shadow-sm">
      <thead class="thead-light">
        <tr>
          <th><a href="index.php?sort=email"><i class="fas fa-envelope"></i> Email</a></th>
          <th><a href="index.php?sort=sodienthoai"><i class="fas fa-phone-alt"></i> Số điện thoại</a></th>
          <th><a href="index.php?sort=hoten"><i class="fas fa-user"></i> Họ tên</a></th>
          <th><a href="index.php?sort=loai"><i class="fas fa-user-tag"></i> Loại quyền</a></th>
          <th><i class="fas fa-toggle-on"></i> Trạng thái</th>
          <th><i class="fas fa-lock"></i> Khóa</th>
          <th><i class="fas fa-trash-alt"></i> Xóa</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($nguoidung as $nd): ?>
          <tr>
            <td><?php echo htmlspecialchars($nd["email"]); ?></td>
            <td><?php echo htmlspecialchars($nd["sodienthoai"]); ?></td>
            <td><?php echo htmlspecialchars($nd["hoten"]); ?></td>
            <td>
              <?php
              switch ($nd["loai"]) {
                case 1:
                  echo '<span class="badge bg-primary">Quản trị</span>';
                  break;
                case 2:
                  echo '<span class="badge bg-info text-dark">Nhân viên</span>';
                  break;
                default:
                  echo '<span class="badge bg-secondary">Khách hàng</span>';
              }
              ?>
            </td>
            <td>
              <?php if ($nd["loai"] != 1): ?>
                <?php if ($nd["trangthai"] == 1): ?>
                  <span class="badge bg-success">Kích hoạt</span>
                <?php else: ?>
                  <span class="badge bg-danger">Đã khóa</span>
                <?php endif; ?>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($nd["loai"] != 1): ?>
                <?php if ($nd["trangthai"] == 1): ?>
                  <a href="?action=khoa&trangthai=0&mand=<?php echo $nd["id"]; ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-lock"></i> Khóa
                  </a>
                <?php else: ?>
                  <a href="?action=khoa&trangthai=1&mand=<?php echo $nd["id"]; ?>" class="btn btn-success btn-sm">
                    <i class="fas fa-unlock"></i> Kích hoạt
                  </a>
                <?php endif; ?>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($nd["loai"] != 1): ?>
                <a href="?action=xoa&mand=<?php echo $nd["id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?');">
                  <i class="fas fa-trash-alt"></i> Xóa
                </a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include("../inc/bottom.php"); ?>
