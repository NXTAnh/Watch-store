<?php include("../inc/top.php"); ?>

<h4 class="text-info">Thêm chương trình khuyến mãi</h4>

<form action="index.php?action=xlthem" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="tenkhuyenmai">Tên khuyến mãi</label>
        <input type="text" name="tenkhuyenmai" id="tenkhuyenmai" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="mota">Mô tả</label>
        <textarea name="mota" id="mota" class="form-control"></textarea>
    </div>
    <div class="mb-3 mt-3">
        <label for="banner">Banner</label>
        <input class="form-control" type="file" name="banner" id="banner">
    </div>
    <div class="form-group">
        <label for="phantramgiam">Phần trăm giảm</label>
        <input type="number" name="phantramgiam" id="phantramgiam" class="form-control" min="0" max="100" required>
    </div>
    <div class="form-group">
        <label for="ngaybatdau">Ngày bắt đầu</label>
        <input type="date" name="ngaybatdau" id="ngaybatdau" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="ngayketthuc">Ngày kết thúc</label>
        <input type="date" name="ngayketthuc" id="ngayketthuc" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Thêm khuyến mãi</button>
</form>
<?php include("../inc/bottom.php"); ?>