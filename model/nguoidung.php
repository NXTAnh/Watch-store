<?php
class NGUOIDUNG
{

	public function kiemtranguoidunghople($email, $matkhau, $is_admin_page)
	{
		$db = DATABASE::connect();
		try {
			$sql = "SELECT * FROM nguoidung WHERE email=:email AND matkhau=:matkhau AND trangthai=1";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(":email", $email);
			$cmd->bindValue(":matkhau", md5($matkhau));
			$cmd->execute();
			$valid = ($cmd->rowCount() == 1);
			$ng = $cmd->fetch();
			if ($is_admin_page && $ng['loai'] === '3') {
				return FALSE;
			}
			$cmd->closeCursor();
			return $valid;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}

	// lấy thông tin người dùng có $email
	public function laythongtinnguoidung($email)
	{
		$db = DATABASE::connect();
		try {
			$sql = "SELECT * FROM nguoidung WHERE email=:email";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(":email", $email);
			$cmd->execute();
			$ketqua = $cmd->fetch();
			$cmd->closeCursor();
			return $ketqua;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}
	// lấy thông tin người dùng có $id
	public function laynguoidungtheoid($id)
	{
		$db = DATABASE::connect();
		try {
			$sql = "SELECT * FROM nguoidung WHERE id=:id";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(":id", $id);
			$cmd->execute();
			$ketqua = $cmd->fetch();
			$cmd->closeCursor();
			return $ketqua;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}

	// lấy tất cả ng dùng
	public function laydanhsachnguoidung($permission = 0)
	{
		$db = DATABASE::connect();
		try {
			$sql = "";
			if ($permission === 0) {
				$sql = "SELECT * FROM nguoidung";
			} else {
				$sql = "SELECT * FROM nguoidung WHERE loai like $permission";
			}
			$cmd = $db->prepare($sql);
			$cmd->execute();
			$ketqua = $cmd->fetchAll();
			return $ketqua;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}

	// Thêm ng dùng mới, trả về khóa của dòng mới thêm
	public function themnguoidung($email, $matkhau, $sodt, $hoten, $loai)
	{
		$db = DATABASE::connect();
		try {
			$sql = "INSERT INTO nguoidung(email,matkhau,sodienthoai,hoten,loai) VALUES(:email,:matkhau,:sodt,:hoten,:loai)";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':email', $email);
			$cmd->bindValue(':matkhau', md5($matkhau));
			$cmd->bindValue(':sodt', $sodt);
			$cmd->bindValue(':hoten', $hoten);
			$cmd->bindValue(':loai', $loai);
			$cmd->execute();
			$id = $db->lastInsertId();
			return $id;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}

	// Cập nhật thông tin ng dùng: họ tên, số đt, email, ảnh đại diện 
	public function capnhatnguoidung($id, $email, $sodt, $hoten, $hinhanh)
	{
		$db = DATABASE::connect();
		try {
			$sql = "UPDATE nguoidung set hoten=:hoten, email=:email, sodienthoai=:sodt, hinhanh=:hinhanh where id=:id";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':id', $id);
			$cmd->bindValue(':email', $email);
			$cmd->bindValue(':sodt', $sodt);
			$cmd->bindValue(':hoten', $hoten);
			$cmd->bindValue(':hinhanh', $hinhanh);
			$ketqua = $cmd->execute();
			return $ketqua;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}

	// Đổi mật khẩu
	public function doimatkhau($email, $matkhau)
	{
		$db = DATABASE::connect();
		try {
			$sql = "UPDATE nguoidung set matkhau=:matkhau where email=:email";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':email', $email);
			$cmd->bindValue(':matkhau', md5($matkhau));
			$ketqua = $cmd->execute();
			return $ketqua;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}

	// Đổi quyền (loại người dùng: 1 quản trị, 2 nhân viên. Không cần nâng cấp quyền đối với loại người dùng 3-khách hàng)
	public function doiloainguoidung($email, $loai)
	{
		$db = DATABASE::connect();
		try {
			$sql = "UPDATE nguoidung set loai=:loai where email=:email";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':email', $email);
			$cmd->bindValue(':loai', $loai);
			$ketqua = $cmd->execute();
			return $ketqua;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}

	// Đổi trạng thái (0 khóa, 1 kích hoạt)
	public function doitrangthai($id, $trangthai)
	{
		$db = DATABASE::connect();
		try {
			$sql = "UPDATE nguoidung set trangthai=:trangthai where id=:id";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':id', $id);
			$cmd->bindValue(':trangthai', $trangthai);
			$ketqua = $cmd->execute();
			return $ketqua;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}
	//xóa người dùng
	public function xoa($id)
	{
		$db = DATABASE::connect();
		try {
			$sql = "DELETE FROM nguoidung where id=:id";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':id', $id);
			$ketqua = $cmd->execute();
			return $ketqua;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}
}
