<?php
session_start();
require("../../model/database.php");
require("../../model/nguoidung.php");
require("../../model/donhang.php");
require("../../model/donhangct.php");
require("../../model/mathang.php");
require("../../model/diachi.php");


// Biến $isLogin cho biết người dùng đăng nhập chưa
$isLogin = isset($_SESSION["nguoidung"]);


// Xét xem có thao tác nào được chọn
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
} elseif ($isLogin == FALSE) {  // chưa đăng nhập
    $action = "dangnhap";
} else {   // mặc định
    $action = "macdinh";
}

$nd = new NGUOIDUNG();
$dh = new DONHANG();

switch ($action) {
    case "macdinh":
        if (isset($_GET["ngay"]) && $_GET["ngay"] != "") {
            $ngay = $_GET["ngay"];
            $dsdonhang = $dh->laydonhangtheongay($ngay);
        } else {
            $dsdonhang = $dh->laydanhsachdonhang();
        }
        include("main.php");
        break;
    

    case "chitiet":
        $id = $_REQUEST['id'];
        $donhang = $dh->laydonhangtheoid($id);
        $dsmathang = $dh->laytatcadonhangcttheoid($id);
        include("chitiet.php");
        break;

    case "xoa":
        $id = $_REQUEST['id'];
        $dh = new DONHANG();
        // xóa
        $dh->xoadonhang($id);
        $dsdonhang = $dh->laydanhsachdonhang();
        include("main.php");
        break;
    default:
        break;
}
