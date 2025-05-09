<?php
if (isset($_GET["tb"]) && $_GET["tb"] == "phai_dang_nhap") {
    echo "<div style='color: red; margin-bottom: 10px;'>Bạn cần đăng nhập để mua hàng.</div>";
}
?>

<style>
/* === FORM ĐĂNG NHẬP RIÊNG === */
.login-wrapper {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(to right, #e3f2fd, #ffffff);
    padding: 2rem 1rem;
}

.login-card {
    border: none;
    border-radius: 15px;
    padding: 2rem;
    background: #fff;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    width: 100%;
    max-width: 400px;
}

.login-card h3 {
    font-weight: 700;
    color: #0d6efd;
    margin-bottom: 1.5rem;
    text-align: center;
}

.login-card input.form-control {
    height: 45px;
    border-radius: 10px;
    border: 1px solid #ced4da;
    transition: border-color 0.3s;
}

.login-card input.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

/* Button riêng cho login */
.login-card .btn {
    height: 45px;
    font-weight: 500;
    border-radius: 10px;
    font-size: 1rem;
}

.login-card .btn-outline-secondary:hover {
    background-color: #6c757d;
    color: #fff;
}
</style>

<?php include("inc/top.php"); ?>

<div class="login-wrapper">
    <div class="login-card">
        <h3>Đăng Nhập</h3>
        <form method="post" action="index.php">
            <div class="mb-3">
                <input type="text" class="form-control" name="txtemail" placeholder="Tên (email)" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="txtmatkhau" placeholder="Mật khẩu" required>
            </div>
            <input type="hidden" name="action" value="xldangnhap">
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
                <a href="index.php?action=dangky" class="btn btn-outline-secondary">Đăng ký</a>
            </div>
        </form>
    </div>
</div>

<?php include("inc/bottom.php"); ?>
