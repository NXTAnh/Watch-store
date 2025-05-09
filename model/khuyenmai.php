<?php 
class KHUYENMAI {
    // khai báo các biến 
    private $id	;
    private $tenkhuyenmai;
    private	$mota;
    private	$banner;
    private	$phantramgiam;
    private	$ngaybatdau;
    private	$ngayketthuc;
    private $trangthai;

        // Getter and Setter for $id
        public function getId() { return $this->id;}
        public function setId($id) { $this->id = $id; }
        // Getter and Setter for $tenkhuyenmai
        public function getTenKhuyenMai() { return $this->tenkhuyenmai;}
        public function setTenKhuyenMai($tenkhuyenmai) {  $this->tenkhuyenmai = $tenkhuyenmai; }
        // Getter and Setter for $mota
        public function getMota() {  return $this->mota;}
        public function setMota($mota) { $this->mota = $mota;}
        // Getter and Setter for $banner
        public function getBanner() {return $this->banner;}
        public function setBanner($banner) {$this->banner = $banner;}
        // Getter and Setter for $phantramgiam
        public function getPhanTramGiam() {  return $this->phantramgiam;}
        public function setPhanTramGiam($phantramgiam) {$this->phantramgiam = $phantramgiam;  }
        // Getter and Setter for $ngaybatdau
        public function getNgayBatDau() {  return $this->ngaybatdau;   }
        public function setNgayBatDau($ngaybatdau) { $this->ngaybatdau = $ngaybatdau;}
        // Getter and Setter for $ngayketthuc
        public function getNgayKetThuc() { return $this->ngayketthuc; }
        public function setNgayKetThuc($ngayketthuc) { $this->ngayketthuc = $ngayketthuc;}
        // Getter and setter for tranghai
        public function getTrangThai() { return $this->trangthai;}
        public function setTragThai($trangthai) { $this->trangthai = $trangthai;}
    
    // Lấy danh sách khuyến mãi
    public function layDanhSachKhuyenMai() {
        $db = DATABASE::connect();
        try {
            $sql = "SELECT * FROM khuyenmai ORDER BY ngaybatdau DESC";
            $cmd = $db->prepare($sql);
            $cmd->execute();
            return $cmd->fetchAll();
        } catch (PDOException $e) {
            echo "<p>Lỗi truy vấn: {$e->getMessage()}</p>";
            return [];
        }
    }
    public function laychuongtrinhkhuyenmai(){
        $db = DATABASE::connect();
        try{
            $sql = "SELECT * FROM khuyenmai WHERE trangthai like 1"; 
            $cmd = $db->prepare($sql);
            $cmd->execute();
            return $cmd->fetch();
            }catch (PDOException $e) {
                echo "<p>Lỗi truy vấn: {$e->getMessage()}</p>";
                return null;
            }          
    }

    // lấy danh sách khuyến mãi theo id 
    public function layDanhSachKhuyenMaiTheoId($id) {
        $db = DATABASE::connect();
        try {
            $sql = "SELECT * FROM khuyenmai WHERE id = :id";
            $cmd = $db->prepare($sql);
            $cmd->bindParam(':id', $id);
            $cmd->execute();
            return $cmd->fetch();
            } catch (PDOException $e) {
                echo "<p>Lỗi truy vấn: {$e->getMessage()}</p>";
                return [];
                }

         }

    // Thêm chương trình khuyến mãi 	
    public function themKhuyenMai($khuyenmai) {
        $db = DATABASE::connect();
        try {
            $sql = "INSERT INTO khuyenmai (tenkhuyenmai, mota, banner, phantramgiam, ngaybatdau, ngayketthuc)
                    VALUES (:tenkhuyenmai, :mota, :banner, :phantramgiam, :ngaybatdau, :ngayketthuc)";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(':tenkhuyenmai',$khuyenmai->tenkhuyenmai);
            $cmd->bindValue(':mota', $khuyenmai->mota);
            $cmd->bindValue(':banner', $khuyenmai->banner);
            $cmd->bindValue(':phantramgiam', $khuyenmai->phantramgiam);
            $cmd->bindValue(':ngaybatdau', $khuyenmai->ngaybatdau);
            $cmd->bindValue(':ngayketthuc', $khuyenmai->ngayketthuc);
            return $cmd->execute();
        } catch (PDOException $e) {
            echo "<p>Lỗi thêm khuyến mãi: {$e->getMessage()}</p>";
            return false;
        }
    }

    // Xóa chương trình khuyến mãi
    public function xoaKhuyenMai($id) {
        $db = DATABASE::connect();
        try {
            $sql = "DELETE FROM khuyenmai WHERE id = :id";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(':id', $id);
            return $cmd->execute();
        } catch (PDOException $e) {
            echo "<p>Lỗi xóa khuyến mãi: {$e->getMessage()}</p>";
            return false;
        }
    }
    // sửa chương trình khuyến mãi
    public function suaKhuyenMai($khuyenmai) {
        $db = DATABASE::connect();
        try {
            $sql = "UPDATE khuyenmai SET 
                        tenkhuyenmai = :tenkhuyenmai, 
                        mota = :mota, 
                        banner = :banner, 
                        phantramgiam = :phantramgiam, 
                        ngaybatdau = :ngaybatdau, 
                        ngayketthuc = :ngayketthuc 
                    WHERE id = :makhuyenmai";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(':tenkhuyenmai', $khuyenmai->tenkhuyenmai);
            $cmd->bindValue(':mota', $khuyenmai->mota);
            $cmd->bindValue(':banner', $khuyenmai->banner);
            $cmd->bindValue(':phantramgiam', $khuyenmai->phantramgiam);
            $cmd->bindValue(':ngaybatdau', $khuyenmai->ngaybatdau);
            $cmd->bindValue(':ngayketthuc', $khuyenmai->ngayketthuc);
            $cmd->bindValue(':makhuyenmai', $khuyenmai->id, PDO::PARAM_INT);
            return $cmd->execute();
        } catch (PDOException $e) {
            echo "<p>Lỗi sửa khuyến mãi: {$e->getMessage()}</p>";
            return false;
        }
    }
    public function getStatus($id) { 
        $db = DATABASE::connect();
         try { $sql = "SELECT trangthai FROM khuyenmai WHERE id = :id";
             $cmd = $db->prepare($sql);
              $cmd->bindValue(':id', $id, PDO::PARAM_INT);
               $cmd->execute(); 
               return $cmd->fetchColumn(); }
                catch (PDOException $e) {
                     echo "<p>Lỗi truy vấn: {$e->getMessage()}</p>"; 
                     return false; }
                     } 
    public function updateStatus($id, $status) 
    { $db = DATABASE::connect(); 
        try { 
            $sql = "UPDATE khuyenmai SET trangthai = :status WHERE id = :id";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(':status', $status, PDO::PARAM_INT);
            $cmd->bindValue(':id', $id, PDO::PARAM_INT);
            return $cmd->execute(); } 
            catch (PDOException $e) {
                 echo "<p>Lỗi cập nhật trạng thái: {$e->getMessage()}</p>"; 
                 return false; 
                }
    
    }
}
?>