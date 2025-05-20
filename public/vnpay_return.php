<?php
require_once("model/vnpay.php");
require_once("model/database.php"); // Đảm bảo file này có class DATABASE

if (isset($_GET['vnp_TransactionNo'])) {
    $donhang_id     = $_GET['vnp_TxnRef'];
    $amount         = $_GET['vnp_Amount'];
    $bankcode       = $_GET['vnp_BankCode'];
    $banktranno     = $_GET['vnp_BankTranNo'];
    $cardtype       = $_GET['vnp_CardType'];
    $orderinfo      = $_GET['vnp_OrderInfo'];
    $paydate        = $_GET['vnp_PayDate'];
    $tmncode        = $_GET['vnp_TmnCode'];
    $transactionno  = $_GET['vnp_TransactionNo'];

    // Khởi tạo đối tượng và lưu vào DB
    $vnpay = new VNPAY();
    $vnpay->luuGiaoDich(
        $donhang_id,
        $amount,
        $bankcode,
        $banktranno,
        $cardtype,
        $orderinfo,
        $paydate,
        $tmncode,
        $transactionno
    );

    echo "<h3 style='color: green'>Thanh toán thành công. Giao dịch đã được lưu!</h3>";
} else {
    echo "<h3 style='color: red'>Giao dịch không hợp lệ!</h3>";
}
?>
