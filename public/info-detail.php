<?php include("inc/top.php"); ?>

<br><br>
<div class="container">
    <div class="row">
        <h4>Chi tiết đơn hàng <?php echo $_REQUEST["id"] ?></h4>
        <h6>Ngày tạo: <?php echo $donhang['ngay'] ?></h6>
        <h6>Tổng tiền: <?php echo number_format($donhang['tongtien']) ?>đ</h6>
        <div class="col text-end">
            <a href="./index.php?action=thongtin" class="btn btn-secondary"><b>Trở về</b></a>
        </div>
        <table class="table table-hover">
            <tr>
                <th>Tên mặt hàng</th>
                <th>Giá bán</th>
                <th>Số lượng</th>
                <th>Hình ảnh</th>
            </tr>
            <?php foreach ($dsmathang as $m):   ?>
                <tr>
                    <td>
                        <?php echo $m["tenmathang"]; ?>
                    </td>
                    <td><?php echo number_format($m["giaban"]); ?>đ</td>
                    <td><?php echo number_format($m["soluong"]); ?></td>
                    <td>
                        <img src="../<?php echo $m["hinhanh"]; ?>" width="80" class="img-thumbnail">
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
    </div>
</div>
<?php include("inc/bottom.php"); ?>