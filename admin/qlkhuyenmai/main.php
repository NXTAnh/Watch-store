<?php include("../inc/top.php"); ?>

<h4 class="text-info">Quản lý chương trình khuyến mãi</h4>

<!-- Thêm khuyến mãi -->
<a class="btn btn-success mb-3" href="index.php?action=them">Thêm khuyến mãi</a>

<!-- Bảng quản lý khuyến mãi -->
<table class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>Tên khuyến mãi</th>
            <th>Mô tả</th>
            <th>Phần trăm giảm</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Banner</th> <!-- Cột Banner mới -->
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php
// Lấy danh sách khuyến mãi 
        foreach ($dsKhuyenMai as $km):
        ?>
            <tr>
                <td><?php echo $km['tenkhuyenmai']; ?></td>
                <td><?php echo strlen($km['mota']) > 50 ? substr($km['mota'], 0, 50) . '...' : $km['mota']; ?></td>
                <td><?php echo $km['phantramgiam']; ?>%</td>
                <td><?php echo date('d-m-Y', strtotime($km['ngaybatdau'])); ?></td>
                <td><?php echo date('d-m-Y', strtotime($km['ngayketthuc'])); ?></td>
                <td>
                    <!-- Hiển thị ảnh banner -->
                    <?php if($km['banner']): ?>
                        <img src="../../<?php echo $km['banner']; ?>" alt="Banner" style="width: 100px; height: auto;" class="img-thumbnail">
                    <?php else: ?>
                        <span>Không có banner</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a class="btn btn-success btn-sm" href="index.php?action=themspkm&id=<?php echo $km['id']; ?>" onclick="return confirm('Bạn hãy chọn danh sách sản phẩm muốn đưa vào chương trình khuyến mãi')"><i class="fa fa-plus-square"></i>sản phẩm</a>
                    <a class="btn btn-info btn-sm" href="index.php?action=sua&id=<?php echo $km['id']; ?>"><i class="fas fa-edit"></i> Sửa</a>
                    <a class="btn btn-danger btn-sm" href="index.php?action=xoa&id=<?php echo $km['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa khuyến mãi này?')"><i class="fas fa-trash"></i> Xóa</a>
                    <a class="btn btn-<?php echo $km['trangthai'] ? 'warning' : 'secondary'; ?> btn-sm" href="index.php?action=toggle_status&id=<?php echo $km['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn <?php echo $km['trangthai'] ? 'tắt' : 'bật'; ?> khuyến mãi này?')"> <i class="fas fa-toggle-<?php echo $km['trangthai'] ? 'on' : 'off'; ?>"></i> <?php echo $km['trangthai'] ? 'Tắt' : 'Bật'; ?> </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Thêm Font Awesome cho các biểu tượng -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<?php include("../inc/bottom.php"); ?>
