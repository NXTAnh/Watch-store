<?php

class DONHANG
{
	public function themdonhang($nguoidung_id, $diachi_id, $tongtien, $trangthai = 0, $ghichu = null)
		{
			$db = DATABASE::connect();
			if ($db === null) return false;

			try {
				$sql = "INSERT INTO donhang (nguoidung_id, diachi_id, tongtien, trangthai, ghichu, ngay) 
						VALUES (:nguoidung_id, :diachi_id, :tongtien, :trangthai, :ghichu, NOW())";
				$cmd = $db->prepare($sql);

				$cmd->bindValue(':nguoidung_id', (int)$nguoidung_id, PDO::PARAM_INT);
				$cmd->bindValue(':diachi_id', (int)$diachi_id, PDO::PARAM_INT);
				$cmd->bindValue(':tongtien', (float)$tongtien, PDO::PARAM_STR); // float dùng PDO::PARAM_STR
				$cmd->bindValue(':trangthai', (int)$trangthai, PDO::PARAM_INT);
				$cmd->bindValue(':ghichu', $ghichu, PDO::PARAM_STR);

				$cmd->execute();
				return $db->lastInsertId(); // Trả về donhang_id
			} catch (PDOException $e) {
				error_log("Lỗi khi thêm đơn hàng: " . $e->getMessage());
				return false;
			}
		}
	public function themdonhangTuMaGiaoDich($ma_giao_dich, $nguoidung_id, $diachi_id, $tongtien, $trangthai = 0, $ghichu = null)
		{
			$db = DATABASE::connect();
			if ($db === null) return false;

			try {
				// Kiểm tra nếu đơn hàng đã tồn tại với mã giao dịch này
				$check = $db->prepare("SELECT id FROM donhang WHERE ma_giao_dich = :ma_giao_dich");
				$check->bindValue(':ma_giao_dich', $ma_giao_dich, PDO::PARAM_STR);
				$check->execute();
				if ($check->rowCount() > 0) {
					return $check->fetchColumn(); // trả về id đã có
				}

				$sql = "INSERT INTO donhang (ma_giao_dich, nguoidung_id, diachi_id, tongtien, trangthai, ghichu, ngay) 
						VALUES (:ma_giao_dich, :nguoidung_id, :diachi_id, :tongtien, :trangthai, :ghichu, NOW())";
				$cmd = $db->prepare($sql);

				$cmd->bindValue(':ma_giao_dich', $ma_giao_dich, PDO::PARAM_STR);
				$cmd->bindValue(':nguoidung_id', (int)$nguoidung_id, PDO::PARAM_INT);
				$cmd->bindValue(':diachi_id', (int)$diachi_id, PDO::PARAM_INT);
				$cmd->bindValue(':tongtien', (float)$tongtien);
				$cmd->bindValue(':trangthai', (int)$trangthai, PDO::PARAM_INT);
				$cmd->bindValue(':ghichu', $ghichu, PDO::PARAM_STR);

				$cmd->execute();
				return $db->lastInsertId();
			} catch (PDOException $e) {
				error_log("Lỗi khi thêm đơn hàng từ mã giao dịch: " . $e->getMessage());
				return false;
			}
		}




			public function capnhattrangthai($id, $trangthai)
		{
			$db = DATABASE::connect();
			$sql = "UPDATE donhang SET trangthai = :trangthai WHERE id = :id";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':trangthai', $trangthai);
			$cmd->bindValue(':id', $id);
			$cmd->execute();
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
