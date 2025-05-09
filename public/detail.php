<style>
/* === VÙNG CSS RIÊNG CHO TRANG CHI TIẾT SẢN PHẨM === */
.product-detail-wrapper {
    background-color: #f9f9f9;
    padding: 2rem 1rem;
}
.product-detail-wrapper h1,
.product-detail-wrapper h3,
.product-detail-wrapper h4 {
    font-weight: 700;
}
.product-detail-wrapper img {
    max-width: 100%;
    border-radius: 10px;
    margin-bottom: 1rem;
}
.product-detail-wrapper .form-control {
    border-radius: 8px;
}
.product-detail-wrapper .btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
    border-radius: 8px;
    font-weight: 500;
}
.product-detail-wrapper .card {
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.2s;
}
.product-detail-wrapper .card:hover {
    transform: translateY(-5px);
}
.product-detail-wrapper .card-img-top {
    height: 180px;
    object-fit: cover;
}
.product-detail-wrapper .badge {
    font-size: 0.75rem;
    padding: 0.4em 0.6em;
}
.comment-item {
    border-bottom: 1px solid #ccc;
    padding: 10px 0;
}
.comment-form textarea {
    width: 100%;
    border-radius: 8px;
    padding: 10px;
    margin-bottom: 10px;
}
.comment-form button {
    padding: 8px 16px;
    background: #0d6efd;
    color: white;
    border: none;
    border-radius: 8px;
}
</style>

<?php include("inc/top.php"); ?>
<div class="product-detail-wrapper">
  <div class="container">
    <h1 class="text-danger fw-bold mb-4">Thông tin sản phẩm</h1>

    <div class="row">
      <!-- Cột trái: Chi tiết sản phẩm -->
      <div class="col-sm-9">
        <h3 class="text-info"><?= htmlspecialchars($mhct["tenmathang"]) ?></h3>
        <p><i class="text-muted">Lượt xem: <?= number_format($mhct["luotxem"]) ?></i></p>

        <div><img src="../<?= htmlspecialchars($mhct["hinhanh"]) ?>" alt="<?= htmlspecialchars($mhct["tenmathang"]) ?>"></div>

        <div>
          <h4 class="text-primary">Giá bán:
            <span class="text-danger"><?= number_format($mhct["giaban"]) ?> đ</span>
          </h4>
          
          <form method="post" class="form-inline">
            <input type="hidden" name="action" value="chovaogio">
            <input type="hidden" name="id" value="<?= $mhct["id"] ?>">
            <div class="row mb-3">
              <div class="col">
                <input
                  type="number"
                  class="form-control"
                  name="soluong"
                  value="1"
                  min="1"
                  max="<?= $mhct["soluongton"] ?>"
                  <?= $mhct["soluongton"] == 0 ? 'disabled' : '' ?>
                  required
                  oninvalid="this.setCustomValidity('Vượt quá số lượng tồn kho (hiện còn <?= $mhct["soluongton"] ?>)')"
                  oninput="this.setCustomValidity('')"
                >
                <p class="text-muted mt-2">Số lượng còn: <?= $mhct["soluongton"] ?> sản phẩm</p>
              </div>
              <div class="col">
                <?php if ($mhct["soluongton"] > 0): ?>
                  <input type="submit" class="btn btn-primary" value="Chọn mua">
                <?php else: ?>
                  <button class="btn btn-secondary" disabled>Hết hàng</button>
                <?php endif; ?>
              </div>
            </div>
          </form>


        </div>

        <div class="mt-4">
          <h4 class="text-primary">Mô tả sản phẩm:</h4>
          <?= $mhct["mota"] ?>
        </div>

        <div class="comments-section mt-5">
          <h3 class="text-success">Bình luận</h3>
          <?php if (!empty($dsbinhluan)): ?>
            <?php foreach ($dsbinhluan as $bl): ?>
              <div class="comment-item">
                <p><strong><?= htmlspecialchars($bl['hoten']) ?></strong> - <em><?= $bl['ngay'] ?></em></p>
                <p><?= nl2br(htmlspecialchars($bl['noidung'])) ?></p>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>Chưa có bình luận nào.</p>
          <?php endif; ?>
        </div>

        <div class="comment-form mt-4">
          <h4 class="text-primary">Gửi bình luận</h4>
          <?php if (isset($_SESSION["khachhang"])): ?>
            <form action="index.php?action=binhluan" method="post">
              <input type="hidden" name="id_mathang" value="<?= $mhct["id"] ?>">
              <textarea name="noidung" rows="4" required placeholder="Viết bình luận tại đây..."></textarea>
              <button type="submit">Gửi bình luận</button>
            </form>
          <?php else: ?>
            <p><a href="index.php?action=dangnhap">Đăng nhập</a> để viết bình luận.</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Cột phải: Cùng danh mục -->
      <div class="col-sm-3">
        <h3 class="text-warning">Cùng danh mục:</h3>
        <?php foreach ($mathang as $m):
          if ($m["id"] != $mhct["id"]): ?>
            <div class="mb-4">
              <div class="card shadow">
                <?php if ($m["giaban"] != $m["giagoc"]): ?>
                  <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Giảm giá</div>
                <?php endif; ?>
                <a href="?action=detail&id=<?= $m["id"] ?>">
                  <img class="card-img-top" src="../<?= $m["hinhanh"] ?>" alt="<?= htmlspecialchars($m["tenmathang"]) ?>" />
                </a>
                <div class="card-body p-3 text-center">
                  <a class="text-decoration-none" href="?action=detail&id=<?= $m["id"] ?>">
                    <h5 class="fw-bolder text-info"><?= htmlspecialchars($m["tenmathang"]) ?></h5>
                  </a>
                  <div class="text-warning mb-2">★★★★★</div>
                  <?php if ($m["giaban"] != $m["giagoc"]): ?>
                    <span class="text-muted text-decoration-line-through"><?= number_format($m["giagoc"]) ?>đ</span>
                  <?php endif; ?>
                  <span class="text-danger fw-bolder d-block"><?= number_format($m["giaban"] * 0.9) ?>đ</span>
                </div>
                <div class="card-footer text-center bg-transparent border-top-0">
                  <a class="btn btn-outline-info mt-auto" href="index.php?action=chovaogio&id=<?= $m["id"] ?>">Chọn mua</a>
                </div>
              </div>
            </div>
        <?php endif; endforeach; ?>
      </div>
    </div>
  </div>
</div>
<?php include("inc/bottom.php"); ?>
