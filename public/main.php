<?php
include("inc/top.php");
?>

<!-- Banner khuyến mãi -->
<?php
if ($khuyenmai) {
    echo "<div style='position: relative; height: 400px; margin-bottom: 40px;
                background-image: url(../{$khuyenmai['banner']});
                background-size: cover;
                background-position: center;
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
                overflow: hidden;'>";

    // Lớp overlay giúp chữ dễ đọc
    echo "<div style='position: absolute; top: 0; left: 0; width: 100%; height: 100%;
                '></div>";

    // Tiêu đề khuyến mãi
    echo "<div style='position: absolute; top: 20px; left: 20px; z-index: 2;'>";
    echo "<h1 style='font-size: 3rem; font-weight: 800; color: #FFD700;
                text-shadow: 2px 2px 10px rgba(0,0,0,0.8);
                margin: 0;'>". strtoupper($khuyenmai['tenkhuyenmai']) ."</h1>";
    echo "</div>";

    echo "</div>";
}
?>



<!-- <h3><a class="text-decoration-none text-info" href="index.php?action=group&id=khuyenmai ?>">
        Sản phẩm khuyến mãi</a></h3>
danh sách các sản phẩm khuyến mai -->
<div class="container">
    <h1 class="text-danger fw-bold">Tất cả sản phẩm</h1>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<div class="d-flex justify-content-center my-3">
    <form class="w-100" style="max-width: 98%;" method="GET" action="timkiem.php">
        <div class="input-group shadow-sm">
            <input 
                class="form-control border-primary" 
                type="search" 
                name="tukhoa" 
                placeholder="Tìm sản phẩm..." 
                aria-label="Search">
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>
</div>


<?php
foreach ($danhmuc as $d) {
    $i = 0;
?>
    <div class="container">
        <h3>
            <a class="text-decoration-none text-danger" href="index.php?action=group&id=<?php echo $d["id"]; ?>">
                <?php echo $d["tendanhmuc"]; ?>
            </a>
         </h3>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center ">
            <?php
            foreach ($mathang as $m) {
                if ($m["danhmuc_id"] == $d["id"] && $i < 4) {
                    $i++;
            ?>
                    <div class="col mb-5">
                        <div class="card h-100 shadow">
                            <!-- Sale badge-->
                            <?php if ($m["giaban"] != $m["giagoc"]) { ?>
                                <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Đang giảm giá</div>
                            <?php } // end if 
                            ?>
                            <!-- Product image-->
                            <a href="index.php?action=detail&id=<?php echo $m["id"]; ?>">
                                <img class="card-img-top" src="../<?php echo $m["hinhanh"]; ?>" alt="<?php echo $m["tenmathang"]; ?>" />
                            </a>
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                        <a class="text-decoration-none" href="index.php?action=detail&id=<?php echo $m["id"]; ?>">
                                            <h5 class="fw-bolder text-dark"><?php echo $m["tenmathang"]; ?></h5>
                                        </a>

                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                    <?php if ($m["giaban"] != $m["giagoc"]) { ?>
                                        <span class="text-muted text-decoration-line-through"><?php echo number_format($m["giagoc"]); ?>đ</span><?php } // end if 
                                                                                                                                                ?>
                                    <span class="text-danger fw-bolder"><?php echo number_format($m["giaban"]); ?>đ</span>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-info mt-auto" href="index.php?action=chovaogio&id=<?php echo $m["id"]; ?>">Mua sản phẩm</a></div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>

        </div>
        <?php
        if ($i == 0)
            echo "<h4>Danh mục hiện chưa có sản phẩm.</h4>";
        else
        ?>
        <div class="text-end mb-2"><a class="text-warning text-decoration-none fw-bolder" href="index.php?action=group&id=<?php echo $d["id"]; ?>">Xem thêm <?php echo $d["tendanhmuc"]; ?></a></div>
    <?php
}
    ?>
    </div>
    <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/67ffa0fe2e9dce1918706850/1iov8pp54';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
    <?php
    include("inc/bottom.php");
    ?>