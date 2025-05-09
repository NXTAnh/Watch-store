<?php
class DIACHI
{

	// Thêm địa chỉ mới, trả về khóa của dòng mới thêm
	public function themdiachi($nguoidung_id, $diachi)
	{
		$db = DATABASE::connect();
		try {
			$sql = "INSERT INTO diachi(nguoidung_id, diachi) VALUES(:nguoidung_id,:diachi)";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':nguoidung_id', $nguoidung_id);
			$cmd->bindValue(':diachi', $diachi);
			$cmd->execute();
			$id = $db->lastInsertId();
			return $id;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}
	// Lấy địa chỉ của khách
	public function laydiachitheoid($id)
{
	$db = DATABASE::connect();
	$sql = "SELECT * FROM diachi WHERE id = :id";
	$cmd = $db->prepare($sql);
	$cmd->bindValue(':id', $id);
	$cmd->execute();
	return $cmd->fetch(PDO::FETCH_ASSOC); // trả về mảng, không phải false
}



	// Lấy địa chỉ của khách
	public function laydiachikhachhang($id)
	{
		$dbcon = DATABASE::connect();
		try {
			$sql = "SELECT * FROM diachi WHERE nguoidung_id=:id AND macdinh=1 LIMIT 1";
			$cmd = $dbcon->prepare($sql);
			$cmd->bindValue(":id", $id);
			$cmd->execute();
			$result = $cmd->fetch();
			return $result;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}

	public function xoadiachitheoid($id)
	{
		$dbcon = DATABASE::connect();
		try {
			$sql = "DELETE FROM diachi WHERE id=$id";
			$cmd = $dbcon->prepare($sql);
			$x = $cmd->execute();
			return $x;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}

	public function xoadichitheonguoidung($nguoidung_id)
	{
		$dbcon = DATABASE::connect();
		try {
			$sql = "SELECT * FROM diachi WHERE nguoidung_id=$nguoidung_id";
			$cmd = $dbcon->prepare($sql);
			$cmd->execute();
			$result = $cmd->fetchAll();
			foreach ($result as $diachi) {
				$id = $diachi['id'];
				$this->xoadiachitheoid($id);
			}
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}
}
