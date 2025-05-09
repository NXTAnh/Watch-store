<?php include("../inc/top.php"); ?>
<form action="index.php?action=xulysua" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <input type="hidden" name="id" id="khuyenmai_id" class="form-control" value="<?php echo $khuyenmai['id']; ?>" required>
    </div>
    <div class="form-group">
        <label for="tenkhuyenmai">Tên khuyến mãi</label>
        <input type="text" name="tenkhuyenmai" id="tenkhuyenmai" class="form-control" value="<?php echo $khuyenmai['tenkhuyenmai']; ?>" required>
    </div>

    <div class="form-group">
        <label for="mota">Mô tả</label>
        <textarea name="mota" id="mota" class="form-control"><?php echo $khuyenmai['mota']; ?></textarea>
    </div>

    <div class="mb-3 mt-3">
        <label for="banner">Banner</label>
        <input class="form-control" type="file" name="banner" id="banner">
        <?php if (!empty($khuyenmai['banner'])): ?>
            <img src="../../<?php echo $khuyenmai['banner']; ?>" width="100" class="mt-2">
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="phantramgiam">Phần trăm giảm</label>
        <input type="number" name="phantramgiam" id="phantramgiam" class="form-control" min="0" max="100" value="<?php echo $khuyenmai['phantramgiam']; ?>" required>
    </div>
    <!-- Nút Danh sách sản phẩm bằng thẻ <a> -->
    <div class="form-group"> 
        <a href="index.php?action=suaspkm&id=<?php echo $khuyenmai['id']; ?>" class="btn btn-success">Danh sách sản phẩm</a> </div>
    <div class="form-group">
        <label for="ngaybatdau">Ngày bắt đầu</label>
        <input type="date" name="ngaybatdau" id="ngaybatdau" class="form-control" value="<?php echo $khuyenmai['ngaybatdau']; ?>" required>
    </div>

    <div class="form-group">
        <label for="ngayketthuc">Ngày kết thúc</label>
        <input type="date" name="ngayketthuc" id="ngayketthuc" class="form-control" value="<?php echo $khuyenmai['ngayketthuc']; ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật khuyến mãi</button>
</form>
<?php include("../inc/bottom.php"); ?>