<?php include("../inc/top.php"); ?>

<h3 class="text-info mb-4">🛒 Quản lý mặt hàng</h3> 

<!-- Form tìm kiếm -->
<form method="GET" action="index.php" class="row g-2 align-items-center mb-4">
    <input type="hidden" name="action" value="timkiem">

    <div class="col-md-6">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="🔍 Nhập tên mặt hàng..." required>
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i> Tìm kiếm
                </button>
            </div>
        </div>
    </div>
</form>

<?php if (isset($_GET["action"]) && $_GET["action"] == "timkiem"): ?>
    <a href="index.php" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách mặt hàng
    </a>
<?php endif; ?>

<!-- Nút thêm mặt hàng -->
<a href="index.php?action=them" class="btn btn-info mb-3">
    <i class="fas fa-plus-circle me-1"></i> Thêm mặt hàng
</a>

<!-- Bảng danh sách mặt hàng -->
<div class="table-responsive">
    <table class="table table-bordered table-hover shadow-sm">
        <thead class="thead-light">
            <tr>
                <th>Tên mặt hàng</th>
                <th>Giá bán</th>
                <th>Số lượng</th>
                <th>Hình ảnh</th>		
                <th>Sửa</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($mathang as $m): ?>
            <tr>
                <td>
                    <a href="index.php?action=chitiet&id=<?php echo $m["id"]; ?>">
                        <?php echo htmlspecialchars($m["tenmathang"]); ?>
                    </a>
                </td>
                <td class="text-success"><?php echo number_format($m["giaban"]); ?>đ</td>
                <td><?php echo $m["soluongton"]; ?></td>
                <td>
                    <a href="index.php?action=chitiet&id=<?php echo $m["id"]; ?>">
                        <img src="../../<?php echo $m["hinhanh"]; ?>" width="80" class="img-thumbnail">
                    </a>
                </td>
                <td>
                    <a class="btn btn-warning" href="index.php?action=sua&id=<?php echo $m["id"]; ?>">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
                <td>
                    <a class="btn btn-danger" href="index.php?action=xoa&id=<?php echo $m["id"]; ?>">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include("../inc/bottom.php"); ?>
