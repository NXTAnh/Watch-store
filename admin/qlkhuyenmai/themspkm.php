<?php include("../inc/top.php"); ?>
    <div class="container mt-4">
        <h2 class="text-center">Thêm Sản Phẩm Vào Chương Trình Khuyến Mãi</h2>
        <form action="index.php?action=xlthemspkm" method="POST">
            <div class="table-responsive">
            <input type="hidden" name="khuyenmai_id" value="<?php echo $ctkm['id']; ?>">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Chọn</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Giá Bán</th>
                            <th>Số Lượng Tồn</th>
                            <th>Nhập Số Lượng</th>
                            <th>Hình Ảnh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mathang as $product): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="sanpham[]" value="<?php echo $product['id']; ?>">
                                </td>
                                <td><?php echo htmlspecialchars($product['tenmathang']); ?></td>
                                <td><?php echo number_format($product['giaban']); ?> đ</td>
                                <td><?php echo $product['soluongton']; ?></td>
                                <td>
                                    <input type="number" name="soluong[<?php echo $product['id']; ?>]" class="form-control" min="1" max="<?php echo $product['soluongton']; ?>">
                                </td>
                                <td>
                                    <img src="../../<?php echo htmlspecialchars($product['hinhanh']); ?>" alt="Hình ảnh sản phẩm" width="80" class="img-thumbnail">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary">Xác Nhận Danh Sách</button>
            </div>
        </form>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<?php include("../inc/bottom.php"); ?>