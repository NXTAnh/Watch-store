<?php include("../inc/top.php"); ?>

<h4 class="text-info">Sửa danh sách sản phẩm khuyến mãi</h4>

<form action="index.php?action=xulysuaspkm" method="POST">
    <input type="hidden" name="khuyenmai_id" value="<?php echo $khuyenmai['id']; ?>">

    <div style="max-height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Chọn</th>
                    <th>Tên mặt hàng</th>
                    <th>Giá bán</th>
                    <th>Số lượng</th>
                    <th>Hình ảnh</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mathang as $m): ?>
                    <?php 
                        // Kiểm tra sản phẩm đã có trong khuyến mãi chưa
                        $checked = in_array($m['id'], $spkhuyenmai_ids) ? 'checked' : '';
                        $soluong = isset($soluong_sanpham[$m['id']]) ? $soluong_sanpham[$m['id']] : 0;
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="sanpham[]" value="<?php echo $m['id']; ?>" <?php echo $checked; ?>>
                        </td>
                        <td><?php echo $m['tenmathang']; ?></td>
                        <td><?php echo number_format($m['giaban']); ?> đ</td>
                        <td>
                            <input type="number" name="soluong[<?php echo $m['id']; ?>]" 
                                   value="<?php echo $soluong; ?>" 
                                   class="form-control" min="0">
                        </td>
                        <td>
                            <img src="../../<?php echo $m['hinhanh']; ?>" width="80" class="img-thumbnail">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Cập nhật danh sách sản phẩm</button>
</form>

<?php include("../inc/bottom.php"); ?>
