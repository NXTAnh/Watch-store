<?php

class DONHANG
{
	public function themdonhang($nguoidung_id, $diachi_id, $tongtien)
	{
		$db = DATABASE::connect();
		try {
			$sql = "INSERT INTO donhang(nguoidung_id, diachi_id, tongtien) 
					VALUES(:nguoidung_id,:diachi_id,:tongtien)";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':nguoidung_id', $nguoidung_id);
			$cmd->bindValue(':diachi_id', $diachi_id);
			$cmd->bindValue(':tongtien', $tongtien);
			$cmd->execute();
			return $db->lastInsertId();
		} catch (PDOException $e) {
			echo "<p>Lỗi truy vấn: " . $e->getMessage() . "</p>";
			exit();
		}
	}

	public function laytatcadonhangcttheoid($id)
	{
		$dsdonhang = array();
		$mh_db = new MATHANG();
		$dbcon = DATABASE::connect();
		try {
			$sql = "SELECT * FROM donhangct WHERE donhang_id=:id";
			$cmd = $dbcon->prepare($sql);
			$cmd->bindValue(":id", $id);
			$cmd->execute();
			$result = $cmd->fetchAll();
			foreach ($result as $index => $donhangct) {
				$mh = $mh_db->laymathangtheoid($donhangct['mathang_id']);
				$dsdonhang[$index] = [
					'id' => $donhangct['id'],
					'id_mathang' => $donhangct['mathang_id'],
					'tenmathang' => $mh['tenmathang'],
					'hinhanh' => $mh['hinhanh'],
					'giaban' => $donhangct['dongia'],
					'soluong' => $donhangct['soluong']
				];
			}
			return $dsdonhang;
		} catch (PDOException $e) {
			echo "<p>Lỗi truy vấn: " . $e->getMessage() . "</p>";
			exit();
		}
	}

	public function laydonhangcttheoid($id)
	{
		$dbcon = DATABASE::connect();
		try {
			$sql = "SELECT * FROM donhangct WHERE donhang_id=:id";
			$cmd = $dbcon->prepare($sql);
			$cmd->bindValue(":id", $id);
			$cmd->execute();
			return $cmd->fetch();
		} catch (PDOException $e) {
			echo "<p>Lỗi truy vấn: " . $e->getMessage() . "</p>";
			exit();
		}
	}

	public function laydonhangtheoid($id)
	{
		$nguoidung_db = new NGUOIDUNG();
		$diachi_db = new DIACHI();
		$dbcon = DATABASE::connect();
		try {
			$sql = "SELECT * FROM donhang WHERE id = :id";
			$cmd = $dbcon->prepare($sql);
			$cmd->bindValue(":id", $id);
			$cmd->execute();
			$dh = $cmd->fetch();

			if ($dh && isset($dh['diachi_id']) && isset($dh['nguoidung_id'])) {
				$dc = $diachi_db->laydiachitheoid($dh['diachi_id']);
				$ngd = $nguoidung_db->laynguoidungtheoid($dh['nguoidung_id']);

				return [
					'id' => $dh['id'],
					'tenkh' => $ngd['hoten'] ?? '',
					'diachi' => $dc['diachi'] ?? '',
					'ngay' => $dh['ngay'],
					'tongtien' => $dh['tongtien']
				];
			}
			return null;
		} catch (PDOException $e) {
			echo "<p>Lỗi truy vấn: " . $e->getMessage() . "</p>";
			exit();
		}
	}

	public function laydonhangtheongay($ngay)
	{
		$dsdonhang = array();
		$nguoidung_db = new NGUOIDUNG();
		$diachi_db = new DIACHI();
		$dbcon = DATABASE::connect();
		try {
			$sql = "SELECT * FROM donhang WHERE DATE(ngay) = :ngay ORDER BY id DESC;";
			$cmd = $dbcon->prepare($sql);
			$cmd->bindValue(":ngay", $ngay);
			$cmd->execute();
			$result = $cmd->fetchAll();
			foreach ($result as $index => $donhang) {
				$dc = $diachi_db->laydiachitheoid($donhang['diachi_id']);
				$ngd = $nguoidung_db->laynguoidungtheoid($donhang['nguoidung_id']);

				$dsdonhang[$index] = [
					'id' => $donhang['id'],
					'tenkh' => $ngd['hoten'] ?? 'Không rõ',
					'diachi' => $dc['diachi'] ?? 'Không rõ',
					'ngay' => $donhang['ngay'],
					'tongtien' => $donhang['tongtien']
				];
			}
			return $dsdonhang;
		} catch (PDOException $e) {
			echo "<p>Lỗi truy vấn: " . $e->getMessage() . "</p>";
			exit();
		}
	}
	public function laydonhangtheongaycu($ngay) {
		$db = DATABASE::connect();
		$sql = "SELECT * FROM donhang WHERE DATE(ngay) = ?";
		$cmd = $db->prepare($sql);
		$cmd->execute([$ngay]);
		return $cmd->fetchAll();
	}
	
	public function laydonhangtheothangcu($thang) {
		$db = DATABASE::connect();
		$sql = "SELECT * FROM donhang WHERE DATE_FORMAT(ngay, '%Y-%m') = ?";
		$cmd = $db->prepare($sql);
		$cmd->execute([$thang]);
		return $cmd->fetchAll();
	}
	
	public function laydonhangtheonamcu($nam) {
		$db = DATABASE::connect();
		$sql = "SELECT * FROM donhang WHERE YEAR(ngay) = ?";
		$cmd = $db->prepare($sql);
		$cmd->execute([$nam]);
		return $cmd->fetchAll();
	}
	
	public function laydanhsachdonhang($interval_time = 'all')
{
    $dsdonhang = array();
    $nguoidung_db = new NGUOIDUNG();
    $diachi_db = new DIACHI();
    $dbcon = DATABASE::connect();

    try {
        // Lấy danh sách đơn hàng theo thời gian
        if ($interval_time === 'day') {
            $sql = "SELECT * FROM donhang WHERE DATE(ngay) = CURDATE() ORDER BY id DESC;";
        } elseif ($interval_time === 'month') {
            $sql = "SELECT * FROM donhang WHERE MONTH(ngay) = MONTH(CURDATE()) AND YEAR(ngay) = YEAR(CURDATE()) ORDER BY id DESC;";
        } elseif ($interval_time === 'year') {
            $sql = "SELECT * FROM donhang WHERE YEAR(ngay) = YEAR(CURDATE()) ORDER BY id DESC;";
        } else {
            $sql = "SELECT * FROM donhang ORDER BY id DESC;";
        }

        $cmd = $dbcon->prepare($sql);
        $cmd->execute();
        $result = $cmd->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $index => $donhang) {
            // Khởi tạo giá trị mặc định
            $dc = ['diachi' => 'Không rõ'];
            $ngd = ['hoten' => 'Không rõ'];

            // Lấy địa chỉ nếu có
            if (!empty($donhang['diachi_id'])) {
                $dc_temp = $diachi_db->laydiachitheoid($donhang['diachi_id']);
                if (is_array($dc_temp)) {
                    $dc = $dc_temp;
                }
            }

            // Lấy người dùng nếu có
            if (!empty($donhang['nguoidung_id'])) {
                $ngd_temp = $nguoidung_db->laynguoidungtheoid($donhang['nguoidung_id']);
                if (is_array($ngd_temp)) {
                    $ngd = $ngd_temp;
                }
            }

            // Gán dữ liệu vào danh sách
            $dsdonhang[$index] = [
                'id' => $donhang['id'],
                'tenkh' => $ngd['hoten'],
                'diachi' => $dc['diachi'],
                'ngay' => $donhang['ngay'],
                'tongtien' => $donhang['tongtien']
            ];
        }

        return $dsdonhang;

    } catch (PDOException $e) {
        echo "<p>Lỗi truy vấn: " . $e->getMessage() . "</p>";
        exit();
    }
}




	public function xoadonhang($id)
	{
		$db = DATABASE::connect();
		$dhct_db = new DONHANGCT();
		try {
			$dhct_db->xoadonhangchitiet($id);
			$sql = "DELETE FROM donhang WHERE id = :id";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':id', $id);
			return $cmd->execute();
		} catch (PDOException $e) {
			echo "<p>Lỗi truy vấn: " . $e->getMessage() . "</p>";
			exit();
		}
	}

	public function xoadonhangtheonguoidung($nguoidung_id)
	{
		$db = DATABASE::connect();
		try {
			$sql = "SELECT * FROM donhang WHERE nguoidung_id=:nguoidung_id";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(":nguoidung_id", $nguoidung_id);
			$cmd->execute();
			$result = $cmd->fetchAll();
			foreach ($result as $donhang) {
				$this->xoadonhang($donhang['id']);
			}
		} catch (PDOException $e) {
			echo "<p>Lỗi truy vấn: " . $e->getMessage() . "</p>";
			exit();
		}
	}
}
