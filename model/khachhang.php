<?php
class KHACHHANG
{

	// Thêm khách hàng mới, trả về khóa của dòng mới thêm
	public function themkhachhang($email, $sodt, $hoten)
	{
		$db = DATABASE::connect();
		try {
			$sql = "INSERT INTO nguoidung(email,matkhau,sodienthoai,hoten,loai,trangthai) VALUES(:email,:matkhau,:sodt,:hoten,3,1)";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':email', $email);
			$cmd->bindValue(':matkhau', md5($sodt));
			$cmd->bindValue(':sodt', $sodt);
			$cmd->bindValue(':hoten', $hoten);
			$cmd->execute();
			$id = $db->lastInsertId();
			return $id;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}
	public function kiemtrakhachhanghople($email, $matkhau)
	{
		$db = DATABASE::connect();
		try {
			$sql = "SELECT * FROM nguoidung WHERE email=:email AND matkhau=:matkhau AND trangthai=1 AND loai=3";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(":email", $email);
			$cmd->bindValue(":matkhau", md5($matkhau));
			$cmd->execute();
			$valid = ($cmd->rowCount() == 1);
			$cmd->closeCursor();
			return $valid;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}

	// lấy thông tin người dùng có $email
	public function laythongtinkhachhang($email)
	{
		$db = DATABASE::connect();
		try {
			$sql = "SELECT * FROM nguoidung WHERE email=:email AND loai=3";
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

	public function laydanhsachdonhang($nguoidung_id)
{
	$dsdonhang = array();
	$donhang_db = new DONHANG();
	$mathang_db = new MATHANG();
	$diachi_db = new DIACHI();
	$dbcon = DATABASE::connect();

	try {
		// Sắp xếp theo ID giảm dần để hiển thị đơn hàng mới nhất trước
		$sql = "SELECT * FROM donhang WHERE nguoidung_id = :nguoidung_id ORDER BY id DESC";
		$cmd = $dbcon->prepare($sql);
		$cmd->bindValue(":nguoidung_id", $nguoidung_id);
		$cmd->execute();
		$result = $cmd->fetchAll();

		$index = 0;
		foreach ($result as $donhang) {
			$id = $donhang['id'];
			$dh = $donhang_db->laydonhangtheoid($id);
			$diachi_text = 'Không rõ';

			if (!empty($donhang) && is_array($donhang) && isset($donhang['diachi_id'])) {
				$dc = $diachi_db->laydiachitheoid($donhang['diachi_id']);
				if (!empty($dc) && isset($dc['diachi'])) {
					$diachi_text = $dc['diachi'];
				}
			}

			$dsdonhang[$index]['id'] = $id;
			$dsdonhang[$index]['diachi'] = $diachi_text;
			$dsdonhang[$index]['ngay'] = $dh['ngay'];
			$dsdonhang[$index]['tongtien'] = $dh['tongtien'];
			$index += 1;
		}
		return $dsdonhang;

	} catch (PDOException $e) {
		echo "<p>Lỗi truy vấn: " . $e->getMessage() . "</p>";
		exit();
	}
}


}
