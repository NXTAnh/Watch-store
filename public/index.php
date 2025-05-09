<?php
session_start();
require("../model/database.php");
require("../model/danhmuc.php");
require("../model/mathang.php");
require("../model/nguoidung.php");
require("../model/giohang.php");
require("../model/khachhang.php");
require("../model/diachi.php");
require("../model/khuyenmai.php");
require("../model/sanphamkhuyenmai.php");
require("../model/donhang.php");
require("../model/donhangct.php");
require("../model/binhluan.php");


$dm = new DANHMUC();
$dh = new DONHANG();
$danhmuc = $dm->laydanhmuc();
$mh = new MATHANG();
$mathangxemnhieu = $mh->laymathangxemnhieu();
$mathangnoibat = $mh->laymathangnoibat();
$km = new KHUYENMAI();
$spkm= new SANPHAMKHUYENMAI();

if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
} else {
    $action = "null";
}

switch ($action) {
    case "null":
        $mathang = $mh->laymathang();
        $khuyenmai = $km->laychuongtrinhkhuyenmai();

        $sanphamkm = null;

        if (!empty($khuyenmai) && isset($khuyenmai['id'])) {
            $sanphamkm = $spkm->laySanPhamKhuyenMai($khuyenmai['id']);
        }

        include("main.php");
        break;
    case "group":
        if (isset($_REQUEST["id"])) {
            $madm = $_REQUEST["id"];
            $dmuc = $dm->laydanhmuctheoid($madm);
            $tendm =  $dmuc["tendanhmuc"];
            $page = isset($_REQUEST["page"]) ? intval($_REQUEST["page"]) : 1;
            $total_mh = $mh->laytongsomathangtheodanhmuc($madm);
            $item_per_list = 4;
            $total_page = ceil($total_mh / $item_per_list);
            $mathang = $mh->laymathangtheodanhmuc($madm, $page, $item_per_list);
            include("group.php");
        } else {
            include("main.php");
        }
        break;
        case "detail":
            if (isset($_GET["id"])) {
                $mahang = $_GET["id"];
        
                // Lấy ID người dùng (nếu chưa đăng nhập thì dùng 'guest')
                $nguoidung_id = isset($_SESSION["khachhang"]["id"]) ? $_SESSION["khachhang"]["id"] : "guest";
        
                // Tăng lượt xem nếu chưa xem mặt hàng này
                if (!isset($_SESSION["viewed"][$nguoidung_id][$mahang])) {
                    $mh->tangluotxem($mahang);
                    $_SESSION["viewed"][$nguoidung_id][$mahang] = true;
                }
        
                // Lấy thông tin chi tiết mặt hàng
                $mhct = $mh->laymathangtheoid($mahang);
        
                // Lấy các mặt hàng cùng danh mục
                $madm = $mhct["danhmuc_id"];
                $mathang = $mh->laymathangtheodanhmucall($madm, $mahang, 2);
        
                // Lấy danh sách bình luận
                $bl = new BINHLUAN();
                $dsbinhluan = $bl->layBinhLuanTheoMatHang($mahang);
        
                include("detail.php");
            }
            break;
        
        
        
        case "binhluan":
            if (isset($_SESSION["khachhang"])) {
                $nguoidung_id = $_SESSION["khachhang"]["id"];
                $mathang_id = $_POST["id_mathang"];
                $noidung = trim($_POST["noidung"]);
        
                include_once("model/binhluan.php");
                $bl = new BINHLUAN();
                $bl->thembinhluan($nguoidung_id, $mathang_id, $noidung);
            }
            header("Location: index.php?action=detail&id=$mathang_id");
            exit();
            break;
        
        case "chovaogio":
            if (!isset($_SESSION["khachhang"])) {
                // Nếu chưa đăng nhập, chuyển đến trang đăng nhập và kèm thông báo
                header("Location: index.php?action=dangnhap&tb=phai_dang_nhap");
                exit();
            }
        
            if (isset($_REQUEST["id"]))
                $id = $_REQUEST["id"];
            if (isset($_REQUEST["soluong"]))
                $soluong = $_REQUEST["soluong"];
            else
                $soluong = 1;
        
            if (isset($_SESSION['giohang'][$id])) { // nếu đã có trong giỏ thì tăng số lượng
                $soluong += $_SESSION['giohang'][$id];
                $_SESSION['giohang'][$id] = $soluong;
            } else { // nếu chưa thì thêm vào giỏ
                themhangvaogio($id, $soluong);
            }
        
            $giohang = laygiohang();
            include("cart.php");
            break;
            

    case "giohang":
        $giohang = laygiohang();
        include("cart.php");
        break;

    case "capnhatgio":
        if (isset($_REQUEST["mh"])) {
            $mh_input = $_REQUEST["mh"];
            $_SESSION['giohang_error'] = [];
    
            foreach ($mh_input as $id => $soluong) {
                $soluong = intval($soluong);
                $mathang_info = $mh->laymathangtheoid($id);
                $soluongton = intval($mathang_info['soluongton']);
    
                if ($soluong <= 0) {
                    xoamotmathang($id);
                } elseif ($soluong > $soluongton) {
                    $_SESSION['giohang_error'][] = "Số lượng mặt hàng <strong>{$mathang_info['tenmathang']}</strong> vượt quá tồn kho ({$soluongton} sản phẩm).";
                } else {
                    capnhatsoluong($id, $soluong);
                }
            }
        }
    
        $giohang = laygiohang();
        include("cart.php");
        break;
        

    case "xoagiohang":
        xoagiohang();
        $giohang = laygiohang();
        include("cart.php");
        break;

    case "thanhtoan":
    $giohang = laygiohang();
    $has_error = false;
    $_SESSION['giohang_error'] = [];

    foreach ($giohang as $id => $item) {
        $mathang_info = $mh->laymathangtheoid($id);
        $soluongton = intval($mathang_info['soluongton']);
        $soluongmua = intval($item['soluong']);

        if ($soluongmua > $soluongton) {
            $_SESSION['giohang_error'][] = "Sản phẩm <strong>{$mathang_info['tenmathang']}</strong> chỉ còn {$soluongton} sản phẩm, bạn đã chọn $soluongmua.";
            $has_error = true;
        }
    }

    if ($has_error) {
        $giohang = laygiohang();
        include("cart.php");
    } else {
        include("checkout.php");
    }
    break;


    case "luudonhang":

        $diachi = $_POST["txtdiachi"];
        if (!isset($_SESSION["khachhang"])) {
            $email = $_POST["txtemail"];
            $hoten = $_POST["txthoten"];
            $sodienthoai = $_POST["txtsodienthoai"];
            // lưu thông tin khách nếu chưa có trong db (kiểm tra email có tồn tại chưa)
            $kh = new KHACHHANG();
            $khachhang_id = $kh->themkhachhang($email, $sodienthoai, $hoten);
        } else {
            $khachhang_id = $_SESSION["khachhang"]["id"];
        }
        // lưu địa chỉ giao hàng // cần xử lý địa chỉ cho 2 trường hợp if... else bên trên
        $dc = new DIACHI();
        $diachi_id = $dc->themdiachi($khachhang_id, $diachi);

        // lưu đơn hàng
        $dh = new DONHANG();
        $tongtien = tinhtiengiohang();
        $donhang_id = $dh->themdonhang($khachhang_id, $diachi_id, $tongtien);

        // lưu chi tiết đơn hàng
        $ct = new DONHANGCT();
        $giohang = laygiohang();
        foreach ($giohang as $id => $mh) {
            $dongia = $mh["giaban"];
            $soluong = $mh["soluong"];
            $thanhtien = $mh["thanhtien"];
            $ct->themchitietdonhang($donhang_id, $id, $dongia, $soluong, $thanhtien);
            $mh = new MATHANG();
            $mh->capnhatsoluong($id, $soluong);
        }

        // xóa giỏ hàng
        xoagiohang();

        // chuyển đến trang cảm ơn
        include("message.php");
        break;
    case "dangnhap":
        $khuyenmai = $km->laychuongtrinhkhuyenmai(); // thêm dòng này
        include("loginform.php");
        break;
    case "dangky":
        $khuyenmai = $km->laychuongtrinhkhuyenmai(); // thêm dòng này
        include("registerform.php");
        break;
    case "xldangnhap":
        $email = $_POST["txtemail"];
        $matkhau = $_POST["txtmatkhau"];
        $kh = new KHACHHANG();
        if ($kh->kiemtrakhachhanghople($email, $matkhau) == TRUE) {
            $_SESSION["khachhang"] = $kh->laythongtinkhachhang($email);
            // đọc thông tin (đơn hàng) của kh
            // include("info.php");
            $mathang = $mh->laymathang();
            $khuyenmai = $km->laychuongtrinhkhuyenmai(); // thêm dòng này
            include("main.php");
        } else {
            //$tb = "Đăng nhập không thành công!";
            include("loginform.php");
        }
        break;

    case "xulydangky":
        $email = $_POST["txtemail"];
        $matkhau = $_POST["txtmatkhau"];
        $sodt = $_POST["txtphone"];
        $hoten = $_POST["txtname"];
        $loaind = 3;
        $nguoidung = new NGUOIDUNG();
        $kh = new KHACHHANG();
        if ($nguoidung->laythongtinnguoidung($email)) {   // có thể kiểm tra thêm số đt không trùng
            $tb = "Email này đã được cấp tài khoản!";
        } else {
            if (!$nguoidung->themnguoidung($email, $matkhau, $sodt, $hoten, $loaind)) {
                $tb = "Không thêm được!";
            }
        }
        if ($kh->kiemtrakhachhanghople($email, $matkhau) == TRUE) {
            $_SESSION["khachhang"] = $kh->laythongtinkhachhang($email);
            // đọc thông tin (đơn hàng) của kh
            // include("info.php");
            $mathang = $mh->laymathang();
            $khuyenmai = $km->laychuongtrinhkhuyenmai(); // thêm dòng này
            include("main.php");
        } else {
            //$tb = "Đăng nhập không thành công!";
            include("loginform.php");
        }
        break;

    case "gioithieu":
        include("introduce.php");
        break;

    case "thongtin":
        // đọc thông tin các đơn của khách
        $nguoidung_id = $_SESSION['khachhang']['id'];
        $kh = new KHACHHANG();
        $dsdonhang = $kh->laydanhsachdonhang($nguoidung_id);
        include("info.php"); // trang info.php hiển thị các đơn đã đặt
        break;

    case "thongtinchitiet":
        // đọc thông tin các đơn của khách
        $nguoidung_id = $_SESSION['khachhang']['id'];
        $kh = new KHACHHANG();
        $donhang_id = $_REQUEST['id'];
        $donhang = $dh->laydonhangtheoid($donhang_id);
        $dsmathang = $dh->laytatcadonhangcttheoid($donhang_id);
        include("info-detail.php"); // trang info-detail.php hiển thị chi tiết các đơn đã đặt
        break;

    case "dangxuat":
        unset($_SESSION["khachhang"]);
        xoagiohang(); // Xóa toàn bộ giỏ hàng khi đăng xuất
        $mathang = $mh->laymathang();
        $khuyenmai = $km->laychuongtrinhkhuyenmai();
        include("main.php");
        break;
        
        case "timkiem":
            $tukhoa = isset($_GET['tukhoa']) ? trim($_GET['tukhoa']) : '';
            $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
            $limit = 4;
            $start = ($page - 1) * $limit;
        
            $mathang = [];
            $totalRows = 0;
            $totalPages = 0;
        
            if ($tukhoa !== '') {
                // Đếm tổng kết quả
                $totalRows = $mh->demtheoten($tukhoa);
                $totalPages = ceil($totalRows / $limit);
        
                // Lấy danh sách theo trang
                $mathang = $mh->timkiemtheoten($tukhoa, $start, $limit);
            }
        
            $mathangnoibat = $mh->laymathangnoibat();
            $mathangxemnhieu = $mh->laymathangxemnhieu();
        
            include("timkiem.php");
            break;
        
             
    default:
        break;
}
