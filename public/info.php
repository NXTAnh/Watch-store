<?php include("inc/top.php"); ?>

<br><br>
<div class="container">
    <div class="row">
        <h3>Danh sách đơn hàng đã thanh toán</h3>
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>Địa chỉ</th>
                <th>Ngày tạo</th>
                <th>Tổng tiền</th>
                <th>Chi tiết</th>
            </tr>
            <?php foreach ($dsdonhang as $dh):   ?>
                <tr>
                    <td>
                        <?php echo $dh["id"]; ?>
                    </td>

                    <td>
                        <?php echo $dh["diachi"]; ?>
                    </td>
                    <td>
                        <?php echo $dh["ngay"]; ?>
                    </td>
                    <td>
                        <?php echo number_format($dh["tongtien"]); ?>đ
                    </td>
                    <td>
                        <a class="btn btn-info" href="index.php?action=thongtinchitiet&id=<?php echo $dh["id"]; ?>">Chi tiết</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
    </div>
</div>
<?php include("inc/bottom.php"); ?>