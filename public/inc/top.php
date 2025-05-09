<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . "/../../model/giohang.php");
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop Đồng Hồ Thông Minh - TAShop</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Custom Font & Style -->
    <style>
        /* === RESET MỘT SỐ THUỘC TÍNH === */
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f8f9fa;
    color: #212529;
}

a {
    text-decoration: none;
    color: inherit;
}

a:hover {
    color: #0d6efd;
}

/* === NAVBAR === */
.navbar {
    padding: 0.75rem 1rem;
}

.navbar-brand {
    font-weight: 600;
    font-size: 1.4rem;
    display: flex;
    align-items: center;
}

.navbar-brand i {
    font-size: 1.5rem;
    margin-right: 6px;
}

.nav-link {
    font-size: 1rem;
    transition: color 0.3s ease;
}

.nav-link.active,
.nav-link:hover {
    font-weight: bold;
    color: #ffc107 !important;
}

.dropdown-menu a:hover {
    background-color: #e9ecef;
}

.navbar.bg-primary {
    background-color: #2c3e50 !important; /* màu xám đậm sang trọng */
}


/* === BUTTONS === */
.btn-outline-light {
    font-size: 0.95rem;
    border-radius: 25px;
}

.btn-outline-info {
    border-radius: 50px;
    padding: 0.5rem 1.2rem;
}

/* === SECTION WRAPPER === */
.section-bg {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.03);
}

/* === CARD STYLE === */
.card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #212529;
}

.card .text-danger {
    font-size: 1.2rem;
    font-weight: bold;
}

/* === BADGE GIẢM GIÁ === */
.badge.bg-danger {
    font-size: 0.75rem;
    padding: 0.4em 0.6em;
    border-radius: 12px;
}

/* === BANNER OVERLAY === */
.banner-overlay {
    background: rgba(0, 0, 0, 0.4);
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
}

/* === HEADLINE CHUNG === */
.container h1 {
    font-weight: 700;
    font-size: 2.2rem;
    margin-top: 40px;
    margin-bottom: 30px;
    color: #198754;
}

/* === GIỎ HÀNG ICON === */
.btn .badge {
    font-size: 0.75rem;
    padding: 0.35em 0.5em;
}

/* === RESPONSIVE (Tùy chọn) === */
@media (max-width: 768px) {
    .navbar-brand {
        font-size: 1.2rem;
    }

    .btn-outline-light {
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
    }

    .container h1 {
        font-size: 1.6rem;
    }
}

    </style>
</head>

<body id="top">

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php"><i class="bi bi-smartwatch"></i> TAShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link <?php if ($action == 'null') echo 'active'; ?>" href="index.php">Trang chủ</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link <?php if ($action == 'gioithieu') echo 'active'; ?>" href="?action=gioithieu">Giới thiệu</a>
                    </li> -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Danh mục sản phẩm</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach ($danhmuc as $d): ?>
                                <li>
                                    <a class="dropdown-item" href="?action=group&id=<?php echo $d["id"]; ?>">
                                        <?php echo $d["tendanhmuc"]; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <?php if (isset($_SESSION["khachhang"])): ?>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                            <li class="nav-item">
                                <a class="nav-link text-warning" href="index.php?action=thongtin">
                                    Xin chào, <?php echo $_SESSION["khachhang"]["hoten"]; ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=dangxuat">Đăng xuất</a>
                            </li>
                        </ul>
                    <?php else: ?>
                        <a href="index.php?action=dangnhap" class="btn btn-outline-light me-2">
                            <i class="bi bi-person"></i> Đăng nhập
                        </a>
                    <?php endif; ?>
                    <a href="index.php?action=giohang" class="btn btn-outline-light position-relative">
                        <i class="bi bi-cart3"></i> Giỏ hàng
                        <span class="badge bg-danger text-white ms-1 rounded-pill">
                            <?php echo demsoluongtronggio(); ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-3 section-bg">
            <!-- Nội dung trang sẽ được chèn tại đây -->
