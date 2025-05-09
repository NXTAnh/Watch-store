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

$dh = new DONHANG();

switch ($action) {
    case "macdinh":
        $dsdonhangtheongay = $dh->laydanhsachdonhang('day');
        $tongdoanhthutheongay = 0;
        for ($i = 0; $i < count($dsdonhangtheongay); $i++) {
            $tongdoanhthutheongay += intval($dsdonhangtheongay[$i]['tongtien']);
        }
        $dsdonhangtheothang = $dh->laydanhsachdonhang('month');
        $tongdoanhthutheothang = 0;
        for ($i = 0; $i < count($dsdonhangtheothang); $i++) {
            $tongdoanhthutheothang += intval($dsdonhangtheothang[$i]['tongtien']);
        }
        $dsdonhangtheonam = $dh->laydanhsachdonhang('year');
        $tongdoanhthutheonam = 0;
        for ($i = 0; $i < count($dsdonhangtheonam); $i++) {
            $tongdoanhthutheonam += intval($dsdonhangtheonam[$i]['tongtien']);
        }
        include("main.php");
        break;
        case "loc":
            $ngay = $_POST["ngay"] ?? null;
            $thang = $_POST["thang"] ?? null;
            $nam = $_POST["nam"] ?? null;
        
            $tongdoanhthutheongay = 0;
            $tongdoanhthutheothang = 0;
            $tongdoanhthutheonam = 0;
        
            if ($ngay) {
                $ds = $dh->laydonhangtheongaycu($ngay);
                foreach ($ds as $d) {
                    $tongdoanhthutheongay += $d['tongtien'];
                }
            }
        
            if ($thang) {
                $ds = $dh->laydonhangtheothangcu($thang); // định dạng YYYY-MM
                foreach ($ds as $d) {
                    $tongdoanhthutheothang += $d['tongtien'];
                }
            }
        
            if ($nam) {
                $ds = $dh->laydonhangtheonamcu($nam);
                foreach ($ds as $d) {
                    $tongdoanhthutheonam += $d['tongtien'];
                }
            }
        
            include("main.php");
            break;
        
    default:
        break;
}
