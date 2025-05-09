<?php
class DONHANGCT
{

	// Thêm chi tiết đơn hàng mới, trả về khóa của dòng mới thêm
	public function themchitietdonhang($donhang_id, $mathang_id, $dongia, $soluong, $thanhtien)
	{
		$db = DATABASE::connect();
		try {
			$sql = "INSERT INTO donhangct(donhang_id, mathang_id, dongia, soluong, thanhtien) 
					VALUES(:donhang_id, :mathang_id, :dongia, :soluong, :thanhtien)";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':donhang_id', $donhang_id);
			$cmd->bindValue(':mathang_id', $mathang_id);
			$cmd->bindValue(':dongia', $dongia);
			$cmd->bindValue(':soluong', $soluong);
			$cmd->bindValue(':thanhtien', $thanhtien);
			$cmd->execute();
			$id = $db->lastInsertId();
			return $id;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}

	public function xoadonhangchitiet($id_donhang)
	{
		$db = DATABASE::connect();
		try {
			$sql = "DELETE FROM donhangct
					WHERE donhang_id like $id_donhang";
			$cmd = $db->prepare($sql);
			$cmd->execute();
			$id = $db->lastInsertId();
			return $id;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}

	public function xoadonhangchitiettheomathang($id_mathang)
	{
		$db = DATABASE::connect();
		try {
			$sql = "DELETE FROM donhangct
					WHERE mathang_id like $id_mathang";
			$cmd = $db->prepare($sql);
			$cmd->execute();
			$id = $db->lastInsertId();
			return $id;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}
}
