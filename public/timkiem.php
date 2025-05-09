<?php
require_once("../model/database.php");
require_once("../model/mathang.php");
require_once("../model/danhmuc.php"); 

$mh = new MATHANG();
$dm = new DANHMUC();                 

$mathangnoibat = $mh->laymathangnoibat(); 
$mathangxemnhieu = $mh->laymathangxemnhieu(); 
$danhmuc = $dm->laydanhmuc();

include("inc/top.php");             
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
?>

<div class="container">
    <h2 class="text-info mt-4 mb-3">Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($tukhoa); ?>"</h2>
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <?php if (count($mathang) > 0) {
            foreach ($mathang as $m) { ?>
                <div class="col mb-5">
                    <div class="card h-100 shadow">
                        <?php if ($m["giaban"] != $m["giagoc"]) { ?>
                            <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Đang giảm giá</div>
                        <?php } ?>
                        <a href="index.php?action=detail&id=<?php echo $m["id"]; ?>">
                            <img class="card-img-top" src="../<?php echo $m["hinhanh"]; ?>" alt="<?php echo $m["tenmathang"]; ?>" />
                        </a>
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h5 class="fw-bolder text-info"><?php echo $m["tenmathang"]; ?></h5>
                                <?php if ($m["giaban"] != $m["giagoc"]) { ?>
                                    <span class="text-muted text-decoration-line-through"><?php echo number_format($m["giagoc"]); ?>đ</span>
                                <?php } ?>
                                <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                <span class="text-danger fw-bolder"><?php echo number_format($m["giaban"]); ?>đ</span>
                            </div>
                        </div>
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <a class="btn btn-outline-info mt-auto" href="index.php?action=chovaogio&id=<?php echo $m["id"]; ?>">Mua sản phẩm</a>
                            </div>
                        </div>
                    </div>
                </div>
        <?php }
        } else {
            echo "<p class='text-danger'>Không tìm thấy sản phẩm phù hợp.</p>";
        } ?>
    </div>

    <!-- Phân trang -->
<?php if ($totalPages > 1) { ?>
    <nav>
        <ul class="pagination justify-content-center">
            <!-- Mũi tên trái: lùi về trang trước nếu không ở trang 1 -->
            <?php if ($page > 1) { ?>
                <li class="page-item">
                    <a class="page-link" href="timkiem.php?tukhoa=<?php echo urlencode($tukhoa); ?>&page=<?php echo $page - 1; ?>">
                        <i class="bi bi-caret-left-fill"></i>
                    </a>
                </li>
            <?php } ?>

            <!-- Các số trang -->
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="timkiem.php?tukhoa=<?php echo urlencode($tukhoa); ?>&page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php } ?>

            <!-- Mũi tên phải: sang trang sau nếu chưa ở trang cuối -->
            <?php if ($page < $totalPages) { ?>
                <li class="page-item">
                    <a class="page-link" href="timkiem.php?tukhoa=<?php echo urlencode($tukhoa); ?>&page=<?php echo $page + 1; ?>">
                        <i class="bi bi-caret-right-fill"></i>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
<?php } ?>


<?php include("inc/bottom.php"); ?>
