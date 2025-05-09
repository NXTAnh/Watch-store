    <?php
    session_start();
    require("../../model/database.php");
    require("../../model/nguoidung.php");
    require("../../model/donhang.php");
    require("../../model/donhangct.php");
    require("../../model/mathang.php");
    require("../../model/diachi.php");
    require("../../model/khuyenmai.php");
    require("../../model/danhmuc.php");
    require("../../model/sanphamkhuyenmai.php");



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
    $km = new KHUYENMAI();
    $dm = new DANHMUC();
    $mh = new MATHANG();
    $spkm = new SANPHAMKHUYENMAI();

    switch ($action) {
        case "macdinh":
            $dsKhuyenMai = $km->layDanhSachKhuyenMai(TRUE);
            include("main.php");
            break;
        case "them":
            include("addkhuyenmai.php");    
            break;
            // xử lý thêm chương trình khuyến mãi 
            case "xlthem":
                $hinhanh = "images/products/" . basename($_FILES["banner"]["name"]); // đường dẫn ảnh lưu trong db
                $duongdan = "../../" . $hinhanh; // nơi lưu file upload (đường dẫn tính theo vị trí hiện hành)
                move_uploaded_file($_FILES["banner"]["tmp_name"], $duongdan);
                $khuyenmai = new KHUYENMAI();
                 // Sử dụng biến nhất quán
                $khuyenmai->setTenKhuyenMai($_POST['tenkhuyenmai']);
                $khuyenmai->setMota($_POST['mota']);
                $khuyenmai->setBanner($hinhanh);
                $khuyenmai->setPhanTramGiam($_POST['phantramgiam']);
                $khuyenmai->setNgayBatDau($_POST['ngaybatdau']);
                $khuyenmai->setNgayKetThuc($_POST['ngayketthuc']);
 
                // Đảm bảo $km đã được khai báo và khởi tạo trước đó
                if (isset($km)) {
                    $km->themKhuyenMai($khuyenmai);
                    $dsKhuyenMai = $km->layDanhSachKhuyenMai(TRUE);
                    include("main.php");
                } else {
                    echo "<p>Lỗi: Đối tượng \$km chưa được khởi tạo.</p>";
                }
                include('main.php'); 
                header("Location: main.php");
                break;
            // viết lại
            case "sua":
                if (isset($_GET["id"])) {
                    $khuyenmai = $km->layDanhSachKhuyenMaiTheoId($_GET["id"]);
                    include("updatekhuyenmai.php");
                } else {
                    $mathang = $mh->laymathang(TRUE);
                    include("updatekhuyenmai.php");
                }
                break;
            
            case "xulysua":
                $khuyenmai = new KHUYENMAI();
                // Sử dụng biến nhất quán
                $khuyenmai->setId($_POST['id']);
               $khuyenmai->setTenKhuyenMai($_POST['tenkhuyenmai']);
               $khuyenmai->setMota($_POST['mota']);
               $khuyenmai->setPhanTramGiam($_POST['phantramgiam']);
               $khuyenmai->setNgayBatDau($_POST['ngaybatdau']);
               $khuyenmai->setNgayKetThuc($_POST['ngayketthuc']);
            
                    // upload file mới (nếu có)
                if ($_FILES["banner"]["name"] != "") {
                        // xử lý file upload -- Cần bổ dung kiểm tra: dung lượng, kiểu file, ...       
                    $hinhanh = "images/" . basename($_FILES["banner"]["name"]); // đường dẫn lưu csdl
                    $khuyenmai->setBanner($hinhanh);
                    $duongdan = "../../" . $hinhanh; // đường dẫn lưu upload file        
                    move_uploaded_file($_FILES["banner"]["tmp_name"], $duongdan);
                }
            
                // sửa mặt hàng
                $km->suaKhuyenMai($khuyenmai);
            
                // hiển thị ds mặt hàng
                $dsKhuyenMai = $km->layDanhSachKhuyenMai(TRUE);
                include("main.php");
                break;

        case "xoa":
            $id = $_REQUEST['id'];
            $khm = new KHUYENMAI();
            // xóa
            $khm->xoaKhuyenMai($id);
            $dsKhuyenMai = $khm->layDanhSachKhuyenMai();
            include("main.php");
            break;
        case "themspkm":
            $khuyenmai_id = $_REQUEST['id'];
            // Lấy danh sách sản phẩm từ database
            $ctkm= new KHUYENMAI();
            $mh = new MATHANG(); // Tạo đối tượng thao tác với bảng sản phẩm
            $ctkm= $km->layDanhSachKhuyenMaiTheoId($khuyenmai_id);
            $mathang = $mh->laymathang(TRUE);
            include("themspkm.php");
            break;
        case "xlthemspkm":
                // Nhận dữ liệu từ form
                 $khuyenmai_id = isset($_POST['khuyenmai_id']) ? $_POST['khuyenmai_id'] : null;
                if (!$khuyenmai_id) {
                    echo "<script>alert('Chương trình khuyến mãi không tồn tại!');</script>";
                    echo "<script>window.location.href = 'index.php?action=danhsachkm';</script>";
                    break;
                }

                $sanpham_ids = $_POST['sanpham']; // Mảng ID sản phẩm được chọn
                $soluong = $_POST['soluong']; // Mảng số lượng sản phẩm
            
                // Kiểm tra dữ liệu đầu vào
                if (empty($sanpham_ids)) {
                    echo "Vui lòng chọn ít nhất một sản phẩm!";
                    break;
                }
            
                // Khởi tạo đối tượng chi tiết khuyến mãi
                $ctkm = new SANPHAMKHUYENMAI();
            
                // Lặp qua từng sản phẩm để thêm vào chi tiết khuyến mãi
                foreach ($sanpham_ids as $sanpham_id) {
                    // Kiểm tra số lượng hợp lệ
                    $soluong_chon = isset($soluong[$sanpham_id]) ? (int)$soluong[$sanpham_id] : 0;
                    if ($soluong_chon <= 0) {
                        echo "Số lượng sản phẩm $sanpham_id không hợp lệ!";
                        continue;
                    }
                    $ctkm->setMatHangId($sanpham_id);
                    $ctkm->setSoLuong($soluong_chon);
                    $ctkm->setKhuyenMaiId($khuyenmai_id);
                    // Gọi phương thức thêm chi tiết khuyến mãi
                    $result = $ctkm->themSanPhamKhuyenMai($ctkm);
            
                    if (!$result) {
                        echo "Lỗi khi thêm sản phẩm ID $sanpham_id vào khuyến mãi!";
                    }
                }
            
                // Điều hướng hoặc thông báo
                $dsKhuyenMai = $km->layDanhSachKhuyenMai(TRUE);
                echo "<script>alert('Thêm sản phẩm khuyến mãi thành công!');</script>";
                include("main.php");
                break;
            case "suaspkm":
                    $khuyenmai_id = $_REQUEST['id'];
                    // Lấy danh sách sản phẩm từ database
                    $ctkm= new KHUYENMAI();
                    $mh = new MATHANG(); // Tạo đối tượng thao tác với bảng sản phẩm
                    $ctkm= $km->layDanhSachKhuyenMaiTheoId($khuyenmai_id);
                    $mathang = $mh->laymathang(TRUE);
                    include("updatespkhuyemai.php");
                    break;

                // xóa toàn bộ sản phẩm và thêm mới
            case "xulysuaspkm":
                    $khuyenmai_id = $_POST['khuyenmai_id'];
                    $selected_products = $_POST['sanpham'];
                    $product_quantities = $_POST['soluong'];
                
                    // Xóa các sản phẩm hiện tại trong chương trình khuyến mãi
                    $spkm->xoaTatCaSanPhamTrongKhuyenMai($khuyenmai_id);
                
                    // Thêm lại các sản phẩm đã chọn với số lượng tương ứng
                    foreach ($selected_products as $sanpham_id) {
                        // Kiểm tra số lượng hợp lệ
                        $soluong_chon = isset($soluong[$sanpham_id]) ? (int)$soluong[$sanpham_id] : 0;
                        if ($soluong_chon <= 0) {
                            echo "Số lượng sản phẩm $sanpham_id không hợp lệ!";
                            continue;
                        }
                        $ctkm->setMatHangId($sanpham_id);
                        $ctkm->setSoLuong($soluong_chon);
                        $ctkm->setKhuyenMaiId($khuyenmai_id);
                        // Gọi phương thức thêm chi tiết khuyến mãi
                        $result = $ctkm->themSanPhamKhuyenMai($ctkm);
                    }
                    // Lấy danh sách sản phẩm sau khi cập nhật
                    $dsKhuyenMai = $km->layDanhSachKhuyenMai(TRUE);
                    echo "<script>alert('Thêm sản phẩm khuyến mãi thành công!');</script>";
                    include("main.php");
                    break;
                    // thu nghiệm cách không xóa toàn bộ sản phẩm 
            case "toggle_status":
                    
                    if (isset($_GET['action']) && $_GET['action'] == 'toggle_status') {
                        $id = $_GET['id'];
                        $khuyenmai = new KHUYENMAI();
                        $current_status = $khuyenmai->getStatus($id);
                        $new_status = $current_status ? 0 : 1;
                        $khuyenmai->updateStatus($id, $new_status);
                        $dsKhuyenMai= $km->laychuongtrinhkhuyenmai();
                        $dsKhuyenMai = $km->layDanhSachKhuyenMai(TRUE);
                        include("main.php");
                        
                    }
                    break;

            case "xulysuaspkm":
                        $khuyenmai_id = $_POST['khuyenmai_id'];
                        $sanpham_ids = isset($_POST['sanpham']) ? $_POST['sanpham'] : [];
                        $soluong_sanpham = isset($_POST['soluong']) ? $_POST['soluong'] : [];
                    
                        // Xóa toàn bộ sản phẩm cũ trong chương trình khuyến mãi
                        $sql_delete = "DELETE FROM khuyenmai_sanpham WHERE khuyenmai_id = ?";
                        $stmt = $pdo->prepare($sql_delete);
                        $stmt->execute([$khuyenmai_id]);
                    
                        // Thêm lại danh sách sản phẩm mới
                        $sql_insert = "INSERT INTO khuyenmai_sanpham (khuyenmai_id, mathang_id, soluong) VALUES (?, ?, ?)";
                        $stmt_insert = $pdo->prepare($sql_insert);
                    
                        foreach ($sanpham_ids as $mathang_id) {
                            $soluong = isset($soluong_sanpham[$mathang_id]) ? $soluong_sanpham[$mathang_id] : 0;
                    
                            // Chỉ thêm nếu số lượng > 0
                            if ($soluong > 0) {
                                $stmt_insert->execute([$khuyenmai_id, $mathang_id, $soluong]);
                            }
                        }
                    
                        // Chuyển hướng lại trang chính
                        header("Location: index.php?action=suaspkm&id={$khuyenmai_id}&success=1");
                        exit();
                        break;
                        


             default:
                    break;

    }
