            </div>
            </section>

            <section class="py-5">
        <div class="container">
            <div class="row align-items-stretch">
                
                <!-- Carousel bên trái -->
                <div class="col-lg-6 mb-4">
                    <div class="border rounded shadow-sm p-2 bg-white h-100">
                        <?php include("inc/carousel.php"); ?>
                    </div>
                </div>

                <!-- Tabs sản phẩm bên phải -->
                <div class="col-lg-6 mb-4">
                    <div class="border rounded shadow-sm p-3 bg-white h-100">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs mb-3" id="productTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="hot-tab" data-bs-toggle="tab" data-bs-target="#hot" type="button" role="tab" aria-controls="hot" aria-selected="true">
                                    🔥 Nổi bật
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="topview-tab" data-bs-toggle="tab" data-bs-target="#topview" type="button" role="tab" aria-controls="topview" aria-selected="false">
                                    👁️ Xem nhiều
                                </button>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <!-- Sản phẩm nổi bật -->
                            <div class="tab-pane fade show active" id="hot" role="tabpanel" aria-labelledby="hot-tab">
                                <h5 class="text-success fw-bold mb-3">Sản phẩm nổi bật</h5>
                                <?php include("inc/mostview.php"); ?>
                            </div>

                            <!-- Sản phẩm xem nhiều -->
                            <div class="tab-pane fade" id="topview" role="tabpanel" aria-labelledby="topview-tab">
                                <h5 class="text-primary fw-bold mb-3">Sản phẩm xem nhiều</h5>
                                <?php include("inc/topview.php"); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer-->
    

    <footer class="py-5 bg-info">
    <div class="container">
        <div class="row">
            <!-- Left Section: Logo and Contact Information -->
            <div class="col-md-6 text-light">
                <a href="index.php" class="text-decoration-none text-white">
                    <h4>
                        <span class="badge text-white bg-success">T</span>
                        <span class="badge text-white bg-success">A</span> Shop - Cửa hàng đồng hồ thông minh
                    </h4>
                </a>
                <p><b><i>Địa chỉ:</i></b> 18 Ung Văn Khiêm, phường Đông Xuyên, TP Long Xuyên, An Giang<br>
                    <b><i>Điện thoại:</i></b> 099999999<br>
                    <b><i>Email:</i></b> tuonganh@gmail.com
                </p>
            </div>
            <!-- Middle Section: Product Categories -->
            <div class="col-md-3 text-muted">
                <h5><b>DANH MỤC HÀNG</b></h5>
                <?php
                if (!isset($danhmuc)) {
                    require_once(__DIR__ . "/../../model/danhmuc.php");
                    $dm_model = new DANHMUC();
                    $danhmuc = $dm_model->laydanhmuc();
                }

                if (!empty($danhmuc) && is_array($danhmuc)) {
                    foreach ($danhmuc as $d): ?>
                        <b><a class="list-group-item" href="?action=group&id=<?php echo $d["id"]; ?>">
                            <?php echo $d["tendanhmuc"]; ?>
                        </a></b>
                <?php
                    endforeach;
                } else {
                    echo "<p class='text-warning'>Không có danh mục nào.</p>";
                }
                ?>


            </div>
            <!-- Right Section: Customer Services -->
            <div class="col-md-3 text-muted">
    <h5><b>LIÊN HỆ VỚI CHÚNG TÔI</b></h5>
    <b>
        <!-- Facebook Icon -->
        <a href="https://www.facebook.com/yourpage" class="list-group-item d-flex align-items-center">
            <i class="fab fa-facebook-f fa-lg me-2"></i> Facebook
        </a>

        <!-- Zalo Icon -->
        <a href="https://zalo.me/yourzaloid" class="list-group-item d-flex align-items-center">
            <i class="fab fa-zalo fa-lg me-2"></i> Zalo
        </a>

        <!-- Instagram Icon -->
        <a href="https://www.instagram.com/yourprofile" class="list-group-item d-flex align-items-center">
            <i class="fab fa-instagram fa-lg me-2"></i> Instagram
        </a>
    </b>
</div>

        </div>
        <hr>
        <!-- Copyright Section -->
        <p class="m-0 text-center text-warning fw-bolder">Copyright &copy; TAShop</p>
    </div>
</footer>

<!-- Custom Footer Styling -->
<style>
    /* ==== Footer Styling ==== */
    footer {
    background: linear-gradient(135deg, #1c1c1e, #2c3e50); /* Đen xám sang trọng */
    color: #e0e0e0;
    padding: 3rem 0;
    font-family: 'Segoe UI', sans-serif;
}


footer h4, footer h5 {
    font-weight: 700;
    margin-bottom: 1rem;
    color: #fff;
}

footer .badge {
    font-size: 1.2rem;
    margin-right: 0.25rem;
}

footer p {
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 0.5rem;
}

footer .list-group-item {
    background: none;
    border: none;
    color: #e0e0e0;
    padding: 5px 0;
    font-weight: 500;
    transition: color 0.3s, transform 0.3s;
}

footer .list-group-item:hover {
    color: #ffc107;
    transform: translateX(6px);
}

footer a {
    text-decoration: none;
}

footer .fab {
    margin-right: 0.5rem;
    font-size: 1.2rem;
}

footer .text-center {
    margin-top: 2rem;
    font-size: 0.9rem;
    font-weight: bold;
}

footer hr {
    border-color: rgba(255, 255, 255, 0.2);
    margin: 2rem 0 1rem;
}

/* ==== Responsive Carousel Tabs Section ==== */
.section-tabs .nav-tabs .nav-link {
    font-weight: bold;
    color: #495057;
    transition: all 0.3s ease;
}

.section-tabs .nav-tabs .nav-link.active {
    color: #198754;
    border-color: #198754 #198754 #fff;
}

.section-tabs .tab-content h5 {
    color: #0d6efd;
}

.card h-100 {
    transition: transform 0.3s, box-shadow 0.3s;
}
.card h-100:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

</style>

    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>