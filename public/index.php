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
require("../model/vnpay.php");



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
        
    case 'xuly_thanhtoan':
    // Lấy thông tin khách hàng, địa chỉ, giỏ hàng
    $giohang = laygiohang();
    if (empty($giohang)) {
        echo "Giỏ hàng trống, không thể thanh toán.";
        exit();
    }

    if (!isset($_SESSION["khachhang"])) {
        echo "Bạn phải đăng nhập để thanh toán.";
        exit();
    }

    $khachhang_id = $_SESSION["khachhang"]["id"];
    $diachi = $_POST["txtdiachi"] ?? '';

    // Lưu địa chỉ giao hàng
    $dc = new DIACHI();
    $diachi_id = $dc->themdiachi($khachhang_id, $diachi);

    // Tính tổng tiền giỏ hàng
    $tongtien = tinhtiengiohang();

    if ($_POST['httt'] === 'vnpay') {
        // Tạo đơn hàng với trạng thái chưa thanh toán = 0
        $donhang_id = $dh->themdonhang($khachhang_id, $diachi_id, $tongtien, 0); // truyền trạng thái 0

        if (!$donhang_id) {
            echo "Lỗi khi tạo đơn hàng.";
            exit();
        }

        // Lưu chi tiết đơn hàng
        $ct = new DONHANGCT();
        foreach ($giohang as $id => $mh) {
            $dongia = $mh["giaban"];
            $soluong = $mh["soluong"];
            $thanhtien = $mh["thanhtien"];
            $ct->themchitietdonhang($donhang_id, $id, $dongia, $soluong, $thanhtien);

            // Cập nhật tồn kho
            $mhModel = new MATHANG();
            $mhModel->capnhatsoluong($id, $soluong);
        }

        // Xóa giỏ hàng tạm thời để tránh nhầm lẫn
        xoagiohang();

        // Xây dựng URL thanh toán VNPay với donhang_id và tongtien
        $vnp_Url = buildVnpayUrl($donhang_id, $tongtien);
        header("Location: " . $vnp_Url);
        exit();
    } else if ($_POST['httt'] === 'tienmat') {
        // Nếu thanh toán khi nhận hàng, tạo đơn hàng và cập nhật trạng thái đã thanh toán = 1
        $donhang_id = $dh->themdonhang($khachhang_id, $diachi_id, $tongtien, 1); // trạng thái 1

        if (!$donhang_id) {
            echo "Lỗi khi tạo đơn hàng.";
            exit();
        }

        // Lưu chi tiết đơn hàng
        $ct = new DONHANGCT();
        foreach ($giohang as $id => $mh) {
            $dongia = $mh["giaban"];
            $soluong = $mh["soluong"];
            $thanhtien = $mh["thanhtien"];
            $ct->themchitietdonhang($donhang_id, $id, $dongia, $soluong, $thanhtien);

            $mhModel = new MATHANG();
            $mhModel->capnhatsoluong($id, $soluong);
        }

        // Xóa giỏ hàng
        xoagiohang();

        // Hiển thị trang cảm ơn
        include("message.php");
        exit();
    }
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
        $thanhtien = tinhtiengiohang();  // Tính tổng tiền
        include("checkout.php");
    }
    break;


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
        // Lưu đơn hàng
        $donhang_id = $dh->themdonhang($khachhang_id, $diachi_id, $tongtien);

        if ($donhang_id) {
            // Cập nhật trạng thái đơn hàng là đã thanh toán (ví dụ 1)
            $db = DATABASE::connect();
            $sql = "UPDATE donhang SET trangthai = 1 WHERE id = :id";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(':id', $donhang_id);
            $cmd->execute();
        } else {
            // Xử lý lỗi lưu đơn hàng
            echo "Lỗi khi lưu đơn hàng";
            exit();
        }


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

        //vnapay
        case "vnpay_return":
            require_once("../model/vnpay.php");
            require_once("../model/donhang.php");

            $vnpay = new VNPAY();
            $dh = new DONHANG();

            $amount = isset($_GET['vnp_Amount']) ? $_GET['vnp_Amount'] / 100 : 0;
            $bankcode = $_GET['vnp_BankCode'] ?? '';
            $banktranno = $_GET['vnp_BankTranNo'] ?? '';
            $cardtype = $_GET['vnp_CardType'] ?? '';
            $orderinfo = $_GET['vnp_OrderInfo'] ?? '';
            $paydate = $_GET['vnp_PayDate'] ?? '';
            $tmncode = $_GET['vnp_TmnCode'] ?? '';
            $transactionno = $_GET['vnp_TransactionNo'] ?? '';
            $donhang_id = $_GET['vnp_TxnRef'] ?? 0;
            $response_code = $_GET['vnp_ResponseCode'] ?? '';

           if ($response_code === '00') {
            if (!empty($donhang_id)) {
                try {
                    // Lưu giao dịch
                    $saved = $vnpay->luuGiaoDich($amount, $bankcode, $banktranno, $cardtype, $orderinfo, $paydate, $tmncode, $transactionno, $donhang_id);
                    if ($saved) {
                        // Cập nhật trạng thái đơn hàng sang đã thanh toán
                        $db = DATABASE::connect();
                        $sql = "UPDATE donhang SET trangthai = 1 WHERE id = :id";
                        $cmd = $db->prepare($sql);
                        $cmd->bindValue(':id', $donhang_id, PDO::PARAM_INT);
                        $cmd->execute();

                        // Lấy thông tin đơn hàng để hiển thị
                        $donhang = $dh->laydonhangtheoid($donhang_id);
                        $tongtien = $donhang['tongtien'] ?? 0;

                        include("message.php");
                    } else {
                        echo "<p>Lỗi: Không lưu được giao dịch VNPay.</p>";
                    }
                } catch (PDOException $e) {
                    echo "<p>Lỗi khi cập nhật trạng thái đơn hàng: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
            } else {
                echo "<p>Lỗi: ID đơn hàng không hợp lệ.</p>";
            }
        } else {
            echo "<p>Thanh toán không thành công. Mã lỗi: " . htmlspecialchars($response_code) . "</p>";
        }

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
