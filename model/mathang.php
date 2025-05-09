<?php
class MATHANG
{
    // khai báo các thuộc tính
    private $id;
    private $tenmathang;
    private $mota;
    private $giagoc;
    private $giaban;
    private $soluongton;
    private $hinhanh;
    private $danhmuc_id;
    private $luotxem;
    private $luotmua;
    private $trangthai;

    public function getid()
    {
        return $this->id;
    }
    public function setid($value)
    {
        $this->id = $value;
    }
    public function gettenmathang()
    {
        return $this->tenmathang;
    }
    public function settenmathang($value)
    {
        $this->tenmathang = $value;
    }
    public function getmota()
    {
        return $this->mota;
    }
    public function setmota($value)
    {
        $this->mota = $value;
    }
    public function getgiagoc()
    {
        return $this->giagoc;
    }
    public function setgiagoc($value)
    {
        $this->giagoc = $value;
    }
    public function getgiaban()
    {
        return $this->giaban;
    }
    public function setgiaban($value)
    {
        $this->giaban = $value;
    }
    public function getsoluongton()
    {
        return $this->soluongton;
    }
    public function setsoluongton($value)
    {
        $this->soluongton = $value;
    }
    public function gethinhanh()
    {
        return $this->hinhanh;
    }
    public function sethinhanh($value)
    {
        $this->hinhanh = $value;
    }
    public function getdanhmuc_id()
    {
        return $this->danhmuc_id;
    }
    public function setdanhmuc_id($value)
    {
        $this->danhmuc_id = $value;
    }
    public function getluotxem()
    {
        return $this->luotxem;
    }
    public function setluotxem($value)
    {
        $this->luotxem = $value;
    }
    public function getluotmua()
    {
        return $this->luotmua;
    }
    public function setluotmua($value)
    {
        $this->luotmua = $value;
    }
    public function gettrangthai() { return $this->trangthai; }
    public function settrangthai($value) { $this->trangthai = $value; }


    // Lấy danh sách
    public function laymathang($is_admin_page = FALSE)
    {
        $dbcon = DATABASE::connect();
        try {
            $sqlWhere = " WHERE trangthai = 1";
            if ($is_admin_page === FALSE) {
                $sqlWhere .= " AND soluongton > 0";
            }
            $sql = "SELECT * FROM mathang" . $sqlWhere . " ORDER BY id DESC ";
            $cmd = $dbcon->prepare($sql);
            $cmd->execute();
            return $cmd->fetchAll();
        } catch (PDOException $e) {
            echo "<p>Lỗi truy vấn: " . $e->getMessage() . "</p>";
            exit();
        }
    }
    // Lấy tổng số mặt hàng thuộc danh mục
    public function laytongsomathangtheodanhmuc($danhmuc_id)
    {
        $dbcon = DATABASE::connect();
        try {
            $sql = "SELECT COUNT(*) FROM mathang WHERE danhmuc_id=:madm";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":madm", $danhmuc_id);
            $cmd->execute();
            $result = $cmd->fetch();
            return $result[0];
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }
    // Lấy danh sách mặt hàng thuộc tất cả danh mục
    public function laymathangtheodanhmucall($danhmuc_id, $mahang = '', $limit = 0)
    {
        $dbcon = DATABASE::connect();
        try {
            $sqlLimit = "";
            if ($limit > 0) {
                $sqlLimit = " LIMIT $limit";
            }
            $sqlAvoidMatHang = "";
            if ($mahang !== "") {
                $sqlAvoidMatHang = " AND id!=$mahang AND soluongton > 0";
            }
            $sql = "SELECT * FROM mathang WHERE danhmuc_id=$danhmuc_id" . $sqlAvoidMatHang . $sqlLimit;
            $cmd = $dbcon->prepare($sql);
            $cmd->execute();
            $result = $cmd->fetchAll();
            return $result;
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }
    // Lấy danh sách mặt hàng thuộc 1 danh mục
    public function laymathangtheodanhmuc($danhmuc_id, $page, $item_per_list)
    {
        $dbcon = DATABASE::connect();
        try {
            $offset = ($page - 1) * $item_per_list;
            $sql = "SELECT * FROM mathang WHERE danhmuc_id=:madm AND trangthai = 1 ORDER BY id DESC LIMIT $item_per_list OFFSET $offset";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":madm", $danhmuc_id);
            $cmd->execute();
            $result = $cmd->fetchAll();
            return $result;
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }

    // Lấy mặt hàng theo id
    public function laymathangtheoid($id)
    {
        $dbcon = DATABASE::connect();
        try {
            $sql = "SELECT * FROM mathang WHERE id=:id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            return $cmd->fetch();
        } catch (PDOException $e) {
            echo "<p>Lỗi truy vấn: " . $e->getMessage() . "</p>";
            exit();
        }
    }
    // Cập nhật lượt xem
    public function tangluotxem($id)
    {
        $dbcon = DATABASE::connect();
        try {
            $sql = "UPDATE mathang SET luotxem=luotxem+1 WHERE id=:id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":id", $id);
            $result = $cmd->execute();
            return $result;
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }
    // Lấy mặt hàng xem nhiều
    public function laymathangxemnhieu()
    {
        $dbcon = DATABASE::connect();
        try {
            $sql = "SELECT * FROM mathang WHERE soluongton > 0 ORDER BY luotxem DESC LIMIT 3";
            $cmd = $dbcon->prepare($sql);
            $cmd->execute();
            $result = $cmd->fetchAll();
            return $result;
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }



    // Lấy mặt hàng nổi bật
    public function laymathangnoibat()
    {
        $dbcon = DATABASE::connect();
        try {
            $sql = "SELECT * FROM mathang WHERE soluongton > 0 ORDER BY giaban DESC LIMIT 3";
            $cmd = $dbcon->prepare($sql);
            $cmd->execute();
            $result = $cmd->fetchAll();
            return $result;
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }
    public function timkiemtheoten($tukhoa, $start = 0, $limit = 4)
{
    $dbcon = DATABASE::connect();
    try {
        // Ép kiểu để tránh lỗi SQL injection
        $start = (int)$start;
        $limit = (int)$limit;

        $sql = "SELECT * FROM mathang WHERE tenmathang LIKE :tukhoa ORDER BY id DESC LIMIT $start, $limit";
        $cmd = $dbcon->prepare($sql);
        $cmd->bindValue(":tukhoa", '%' . $tukhoa . '%', PDO::PARAM_STR);
        $cmd->execute();
        $result = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $result;
    } catch (PDOException $e) {
        error_log("Lỗi truy vấn timkiemtheoten: " . $e->getMessage());
        return [];
    }
}
    public function demtheoten($tukhoa)
    {
        $dbcon = DATABASE::connect();
        try {
            $sql = "SELECT COUNT(*) FROM mathang WHERE tenmathang LIKE :tukhoa";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":tukhoa", '%' . $tukhoa . '%', PDO::PARAM_STR);
            $cmd->execute();
            $count = $cmd->fetchColumn();
            $cmd->closeCursor();
            return $count;
        } catch (PDOException $e) {
            error_log("Lỗi đếm sản phẩm: " . $e->getMessage());
            return 0;
        }
    }


    

    // Thêm mới
    public function themmathang($mathang)
    {
        $dbcon = DATABASE::connect();
        try {
            $sql = "INSERT INTO mathang(tenmathang,mota,giagoc,giaban,soluongton,danhmuc_id,hinhanh,luotxem,luotmua) 
                VALUES(:tenmathang,:mota,:giagoc,:giaban,:soluongton,:danhmuc_id,:hinhanh,0,0)";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":tenmathang", $mathang->tenmathang);
            $cmd->bindValue(":mota", $mathang->mota);
            $cmd->bindValue(":giagoc", $mathang->giagoc);
            $cmd->bindValue(":giaban", $mathang->giaban);
            $cmd->bindValue(":soluongton", $mathang->soluongton);
            $cmd->bindValue(":danhmuc_id", $mathang->danhmuc_id);
            $cmd->bindValue(":hinhanh", $mathang->hinhanh);
            $result = $cmd->execute();
            return $result;
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }

    // Xóa 
    public function xoamathang($mathang)
{
    $dbcon = DATABASE::connect();
    try {
        $sql = "DELETE FROM mathang WHERE id=:id";
        $cmd = $dbcon->prepare($sql);
        $cmd->bindValue(":id", $mathang->id);
        $result = $cmd->execute();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo "<p>Lỗi truy vấn: $error_message</p>";
        exit();
    }
}


    public function xoamathangtheodanhmuc($danhmuc_id)
    {
        $dsmathang = $this->laymathangtheodanhmucall($danhmuc_id);
        $dhct_db = new DONHANGCT();
        foreach ($dsmathang as $mathang) {
            $dhct_db->xoadonhangchitiettheomathang($mathang['id']);
            $mathanghh = new MATHANG();
            $mathanghh->setid($mathang['id']);
            $this->xoamathang($mathanghh);
        }
    }

    // Cập nhật 
    public function suamathang($mathang)
    {
        $dbcon = DATABASE::connect();
        try {
            $sql = "UPDATE mathang SET tenmathang=:tenmathang,
                                        mota=:mota,
                                        giagoc=:giagoc,
                                        giaban=:giaban,
                                        soluongton=:soluongton,
                                        danhmuc_id=:danhmuc_id,
                                        hinhanh=:hinhanh,
                                        luotxem=:luotxem,
                                        luotmua=:luotmua
                                        WHERE id=:id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":tenmathang", $mathang->tenmathang);
            $cmd->bindValue(":mota", $mathang->mota);
            $cmd->bindValue(":giagoc", $mathang->giagoc);
            $cmd->bindValue(":giaban", $mathang->giaban);
            $cmd->bindValue(":soluongton", $mathang->soluongton);
            $cmd->bindValue(":danhmuc_id", $mathang->danhmuc_id);
            $cmd->bindValue(":hinhanh", $mathang->hinhanh);
            $cmd->bindValue(":luotxem", $mathang->luotxem);
            $cmd->bindValue(":luotmua", $mathang->luotmua);
            $cmd->bindValue(":id", $mathang->id);
            $result = $cmd->execute();
            return $result;
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }

    // Cập nhật số lượng tồn
    public function capnhatsoluong($id, $soluong)
    {
        $dbcon = DATABASE::connect();
        try {
            $sql = "UPDATE mathang SET soluongton=soluongton - :soluong WHERE id=:id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":soluong", $soluong);
            $cmd->bindValue(":id", $id);
            $result = $cmd->execute();
            return $result;
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }
    
}
