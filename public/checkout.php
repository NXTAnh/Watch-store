<?php
include("inc/top.php");


// Gọi tinhtiengiohang một lần duy nhất
$tongtien = tinhtiengiohang();

// Tạo và lưu order_id vào session nếu chưa có
if (!isset($_SESSION['current_order_id'])) {
    $_SESSION['current_order_id'] = uniqid('order_');
}
$order_id = $_SESSION['current_order_id'];
?>

<div class="order-container container my-5">
    <div class="row">
        <h3 class="order-title text-center mb-4">Vui lòng nhập đầy đủ thông tin</h3>
        <div class="col-sm-6">
            <h4 class="order-info-title text-info mb-4">Thông tin khách hàng</h4>
            <?php if (isset($_SESSION["khachhang"])): ?>
                <form method="post" action="index.php" class="order-form">
                    <input type="hidden" name="txtid" value="<?php echo $_SESSION["khachhang"]["id"]; ?>">
                    <input type="hidden" name="action" value="luudonhang">
                    <div class="order-form-group my-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="txtemail" value="<?php echo $_SESSION["khachhang"]["email"]; ?>" disabled>
                    </div>
                    <div class="order-form-group my-3">
                        <label>Họ tên</label>
                        <input type="text" class="form-control" name="txthoten" value="<?php echo $_SESSION["khachhang"]["hoten"]; ?>" disabled>
                    </div>
                    <div class="order-form-group my-3">
                        <label>Số điện thoại</label>
                        <input type="number" class="form-control" name="txtsodienthoai" value="<?php echo $_SESSION["khachhang"]["sodienthoai"]; ?>" disabled>
                    </div>
                    <div class="order-form-group my-3">
                        <label>Địa chỉ giao hàng</label>
                        <textarea class="form-control" name="txtdiachi" required></textarea>
                    </div>
                    <div class="order-form-group my-3">
                        <button type="submit" class="btn btn-success w-100">Thanh toán khi nhận</button>
                    </div>
                </form>

               <!-- Thanh toán VNPay -->
                <form action="vnpay_create_payment.php" method="POST" class="mt-3">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                    <input type="hidden" name="sotien" value="<?php echo (int)$tongtien; ?>" />
                    <input type="hidden" name="hoten" value="<?php echo $_SESSION['khachhang']['hoten']; ?>" />
                    <input type="hidden" name="email" value="<?php echo $_SESSION['khachhang']['email']; ?>" />
                    <input type="hidden" name="sodienthoai" value="<?php echo $_SESSION['khachhang']['sodienthoai']; ?>" />
                    <button type="submit" class="btn btn-warning w-100">Thanh toán VNPay</button>
                </form>
            <?php else: ?>
                <!-- Form khi chưa đăng nhập -->
                <form method="post" action="index.php" class="order-form">
                    <input type="hidden" name="action" value="luudonhang">
                    <div class="order-form-group my-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="txtemail" required>
                    </div>
                    <div class="order-form-group my-3">
                        <label>Họ tên</label>
                        <input type="text" class="form-control" name="txthoten" required>
                    </div>
                    <div class="order-form-group my-3">
                        <label>Số điện thoại</label>
                        <input type="number" class="form-control" name="txtsodienthoai" required>
                    </div>
                    <div class="order-form-group my-3">
                        <label>Địa chỉ</label>
                        <textarea class="form-control" name="txtdiachi" required></textarea>
                    </div>
                    <div class="order-form-group my-3">
                        <input type="submit" value="Hoàn tất đơn hàng" class="btn btn-success w-100">
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <!-- Thông tin đơn hàng -->
        <div class="col-sm-6">
            <h4 class="order-info-title text-info mb-4">Thông tin đơn hàng</h4>
            <table class="table table-bordered">
                <thead>
                    <tr class="table-info">
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($giohang as $id => $mh): ?>
                        <tr>
                            <td><img width="50" src="../<?php echo $mh["hinhanh"]; ?>" class="order-img-thumbnail"><?php echo $mh["tenmathang"]; ?></td>
                            <td><?php echo number_format($mh["giaban"]) . "đ"; ?></td>
                            <td><?php echo $mh["soluong"]; ?></td>
                            <td><?php echo number_format($mh["thanhtien"]) . "đ"; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="table-info">
                        <td colspan="3" class="text-end"><b>Tổng tiền</b></td>
                        <td><b><?php echo number_format($tongtien); ?>đ</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("inc/bottom.php"); ?>


<!-- Custom CSS -->
<style>
    /* General Layout */
    .order-container {
        max-width: 1140px;
        padding: 20px;
    }

    /* Form Styling */
    .order-form {
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #f8f9fa;
        padding: 20px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .order-form-group {
        margin-bottom: 1rem;
    }

    .order-form-group input,
    .order-form-group textarea {
        border-radius: 10px;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.12);
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        padding: 10px;
        font-size: 16px;
        border-radius: 5px;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    /* Table Styling */
    .order-info-title {
        color: #17a2b8;
        font-weight: bold;
    }

    table {
        border-radius: 10px;
        width: 100%;
    }

    table th, table td {
        text-align: center;
        vertical-align: middle;
    }

    table th {
        background-color: #f8f9fa;
    }

    .order-img-thumbnail {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }

    /* Responsive Styling */
    @media (max-width: 767px) {
        .order-container {
            padding: 10px;
        }

        .col-sm-6 {
            margin-bottom: 20px;
        }

        .table th, .table td {
            font-size: 0.85rem;
        }
    }
</style>
