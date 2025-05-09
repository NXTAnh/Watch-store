<?php
include("inc/top.php");
require_once("../model/mathang.php");
$mathang = new MATHANG();
?>
<div class="container">
    <?php if (isset($_SESSION['giohang_error'])): ?>
        <?php foreach ($_SESSION['giohang_error'] as $err): ?>
            <div class="alert alert-danger"><?= $err ?></div>
        <?php endforeach; unset($_SESSION['giohang_error']); ?>
    <?php endif; ?>

    <?php if (demhangtronggio() == 0) { ?>
        <h3 class="text-info">Giỏ hàng trống!</h3>
        <p>Vui lòng chọn sản phẩm...</p>
    <?php } else { ?>
        <h3 class="text-info">Giỏ hàng của bạn:</h3>
        <form action="index.php">
            <table class="table table-hover">
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên hàng</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
                <?php foreach ($giohang as $id => $mh): 
                    $sp = $mathang->laymathangtheoid($id);
                    $soluongton = $sp['soluongton'];
                ?>
                    <tr>
                        <td><img width="50" src="../<?php echo $mh["hinhanh"]; ?>"></td>
                        <td><?php echo $mh["tenmathang"]; ?></td>
                        <td><?php echo number_format($mh["giaban"]); ?>đ</td>
                        <td>
                            <input type="number" 
                                   name="mh[<?php echo $id; ?>]" 
                                   value="<?php echo $mh["soluong"]; ?>" 
                                   min="1" 
                                   max="<?php echo $soluongton; ?>" 
                                   class="form-control"
                                   required
                                   oninvalid="this.setCustomValidity('Vượt quá số lượng tồn kho (Hiện còn <?php echo $soluongton; ?>)')"
                                   oninput="this.setCustomValidity('')">
                            <p class="text-muted small mt-1">Còn: <?php echo $soluongton; ?> sản phẩm</p>
                        </td>
                        <td><?php echo number_format($mh["thanhtien"]); ?>đ</td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"></td>
                    <td class="fw-bold">Tổng tiền</td>
                    <td class="text-danger fw-bold"><?php echo number_format(tinhtiengiohang()); ?>đ</td>
                </tr>
            </table>

            <div class="row">
                <div class="col"><a href="index.php?action=xoagiohang" class="btn btn-warning">Xóa tất cả</a></div>
                <div class="col text-end">
                    <input type="hidden" name="action" value="capnhatgio">
                    <input type="submit" class="btn btn-warning" value="Cập nhật giỏ hàng của bạn">
                    <a href="index.php?action=thanhtoan" class="btn btn-success">Thanh toán</a>
                </div>
            </div>
        </form>
    <?php } ?>
</div>
<?php
include("inc/bottom.php");
?>
