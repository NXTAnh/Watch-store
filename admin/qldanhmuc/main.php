<?php include("../inc/top.php"); ?>

<h4 class="text-info mb-4">
  <i class="fas fa-folder-open"></i> Danh sách danh mục
</h4>

<table class="table table-bordered table-hover shadow-sm">
  <thead class="thead-light">
    <tr>
      <th>ID</th>
      <th>Tên danh mục</th>
      <th><i class="fas fa-edit"></i> Sửa</th>
      <th><i class="fas fa-trash-alt"></i> Xóa</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($danhmuc as $d): ?>
      <?php if ($d["id"] == $idsua): ?>
        <tr>
          <form method="post">
            <input type="hidden" name="action" value="capnhat">
            <input type="hidden" name="id" value="<?php echo $d["id"]; ?>">
            <td><?php echo $d["id"]; ?></td>
            <td>
              <input class="form-control" name="ten" type="text" value="<?php echo htmlspecialchars($d["tendanhmuc"]); ?>">
            </td>
            <td>
              <button class="btn btn-success" type="submit">
                <i class="fas fa-save"></i> Lưu
              </button>
            </td>
          </form>
          <td>
            <a href="index.php?action=xoa&id=<?php echo $d["id"]; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?');">
              <i class="fas fa-trash-alt"></i>
            </a>
          </td>
        </tr>
      <?php else: ?>
        <tr>
          <td><?php echo $d["id"]; ?></td>
          <td><?php echo htmlspecialchars($d["tendanhmuc"]); ?></td>
          <td>
            <a href="index.php?action=sua&id=<?php echo $d["id"]; ?>" class="btn btn-warning">
              <i class="fas fa-edit"></i>
            </a>
          </td>
          <td>
            <a href="index.php?action=xoa&id=<?php echo $d["id"]; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?');">
              <i class="fas fa-trash-alt"></i>
            </a>
          </td>
        </tr>
      <?php endif; ?>
    <?php endforeach; ?>
  </tbody>
</table>

<h5 class="text-info mt-4">
  <a class="text-decoration-none" data-bs-toggle="collapse" data-bs-target="#demo">
    <i class="fas fa-plus-circle"></i> Thêm mới
  </a>
</h5>

<div id="demo" class="collapse mt-3">
  <form method="post">
    <input type="hidden" name="action" value="them">
    <div class="row g-2">
      <div class="col-md-6">
        <input type="text" class="form-control" name="ten" placeholder="Nhập tên danh mục" required>
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-info">
          <i class="fas fa-save"></i> Lưu
        </button>
      </div>
    </div>
  </form>
</div>

<?php include("../inc/bottom.php"); ?>
