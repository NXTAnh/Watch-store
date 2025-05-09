<style>
/* === FORM ĐĂNG KÝ RIÊNG === */
.register-wrapper {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(to right, #ffffff, #e3f2fd);
    padding: 2rem 1rem;
}

.register-card {
    border: none;
    border-radius: 15px;
    padding: 2rem;
    background: #fff;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    width: 100%;
    max-width: 450px;
}

.register-card h3 {
    font-weight: 700;
    color: #198754;
    margin-bottom: 1.5rem;
    text-align: center;
}

.register-card input.form-control {
    height: 45px;
    border-radius: 10px;
    border: 1px solid #ced4da;
    transition: border-color 0.3s;
}

.register-card input.form-control:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
}

.register-card .btn {
    height: 45px;
    font-weight: 500;
    border-radius: 10px;
    font-size: 1rem;
}

.register-card .btn-outline-info:hover {
    background-color: #0dcaf0;
    color: #fff;
}
</style>

<?php include("inc/top.php"); ?>

<div class="register-wrapper">
    <div class="register-card">
        <h3>Đăng Ký</h3>
        <form method="post" action="index.php">
            <div class="mb-3">
                <input type="text" class="form-control" name="txtname" placeholder="Họ tên" required>
            </div>
            <div class="mb-3">
                <input type="tel" class="form-control" name="txtphone" placeholder="Số điện thoại" required>
            </div>
            <div class="mb-3">
                <input type="email" class="form-control" name="txtemail" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="txtmatkhau" placeholder="Mật khẩu" required>
            </div>
            <input type="hidden" name="action" value="xulydangky">
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success">Xác nhận đăng ký</button>
                <a href="index.php?action=dangnhap" class="btn btn-outline-info">Về đăng nhập</a>
            </div>
        </form>
    </div>
</div>

<?php include("inc/bottom.php"); ?>
