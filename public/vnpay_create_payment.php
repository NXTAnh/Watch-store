<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once("./config.php");

// Nhận dữ liệu từ form POST
$vnp_TxnRef = $_POST['order_id']; // Mã đơn hàng
$vnp_Amount = (int)$_POST['sotien']; // Số tiền

$vnp_TxnRef = rand(1,10000); //Mã giao dịch thanh toán tham chiếu của merchant
$vnp_Locale = $_POST['language']; //Ngôn ngữ chuyển hướng thanh toán
$vnp_BankCode = $_POST['bankCode']; //Mã phương thức thanh toán
$vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán
// Tạo nội dung giao dịch
$vnp_OrderInfo = "Thanh toán đơn hàng #" . $vnp_TxnRef;
$vnp_Locale = 'vn';
$vnp_BankCode = ''; // để trống nếu không chọn ngân hàng
$vnp_ExpireDate = date('YmdHis', strtotime('+15 minutes'));

// Tạo mảng dữ liệu gửi đi
$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount* 100,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
    "vnp_OrderType" => "other",
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef,
    "vnp_ExpireDate"=>$expire
);

if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
}

ksort($inputData);
$query = "";
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

$vnp_Url = $vnp_Url . "?" . $query;
if (isset($vnp_HashSecret)) {
    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
}
header('Location: ' . $vnp_Url);
die();

