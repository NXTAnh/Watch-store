
<?php
   class SANPHAMKHUYENMAI {
        private $id; 
        private $khuyenmai_id;
        private $mathang_id; 
        private $soluong;
        private $created_at; 
       // Getter và Setter cho $id 
       public function getId() { return $this->id; } 
       public function setId($id) { $this->id = $id; } 
       // Getter và Setter cho $khuyenmai_id
        public function getKhuyenMaiId() { return $this->khuyenmai_id; }
        public function setKhuyenMaiId($khuyenmai_id) { $this->khuyenmai_id = $khuyenmai_id; }
        // Getter và Setter cho $mathang_id 
        public function getMatHangId() { return $this->mathang_id; } 
        public function setMatHangId($mathang_id) { $this->mathang_id = $mathang_id; } 
        // Getter và Setter cho $soluong 
        public function getSoLuong() { return $this->soluong; } 
        public function setSoLuong($soluong) { $this->soluong = $soluong; } 
        // Getter và Setter cho $created_at 
        public function getCreatedAt() { return $this->created_at; } 
        public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    
        // Lấy danh sách sản phẩm khuyến mãi theo mã chương trình khuyến mãi
        public function laySanPhamKhuyenMai($khuyenmai_id) {
            $db = DATABASE::connect();
            try {
                $sql = "SELECT spkm.*, mh.* 
                        FROM mathang_khuyenmai spkm
                        JOIN mathang mh ON spkm.mathang_id = mh.id
                        WHERE spkm.khuyenmai_id=:khuyenmai_id";
                $cmd = $db->prepare($sql);
                $cmd->bindValue(':khuyenmai_id', $khuyenmai_id);
                $cmd->execute();
                return $cmd->fetchAll();
            } catch (PDOException $e) {
                echo "<p>Lỗi khi lấy danh sách sản phẩm khuyến mãi: {$e->getMessage()}</p>";
                return [];
            }
        }
    
        // Thêm sản phẩm vào chương trình khuyến mãi
        public function themSanPhamKhuyenMai($sanphamkhuyenmai) {
            $db = DATABASE::connect();
            try {
                $sql = "INSERT INTO mathang_khuyenmai (khuyenmai_id, mathang_id, soluong, created_at) 
                        VALUES (:khuyenmai_id, :mathang_id, :soluong, NOW())";
                $cmd = $db->prepare($sql);
                $cmd->bindValue(':khuyenmai_id', $sanphamkhuyenmai->khuyenmai_id);
                $cmd->bindValue(':mathang_id', $sanphamkhuyenmai->mathang_id);
                $cmd->bindValue(':soluong', $sanphamkhuyenmai->soluong);
                return $cmd->execute();
            } catch (PDOException $e) {
                echo "<p>Lỗi khi thêm sản phẩm khuyến mãi: {$e->getMessage()}</p>";
                return false;
            }
        }
    
        // Sửa số lượng sản phẩm trong chương trình khuyến mãi
        public function suaSanPhamKhuyenMai($sanphamkhuyenmai) {
            $db = DATABASE::connect();
            try {
                $sql = "UPDATE sanpham_khuyenmai 
                        SET soluong = :soluong 
                        WHERE khuyenmai_id = :khuyenmai_id AND mathang_id = :mathang_id";
                $cmd = $db->prepare($sql);
                $cmd->bindValue(':khuyenmai_id', $sanphamkhuyenmai->khuyenmai_id);
                $cmd->bindValue(':mathang_id', $sanphamkhuyenmai->mathang_id);
                $cmd->bindValue(':soluong', $sanphamkhuyenmai->soluong);
                return $cmd->execute();
            } catch (PDOException $e) {
                echo "<p>Lỗi khi sửa sản phẩm khuyến mãi: {$e->getMessage()}</p>";
                return false;
            }
        }
    
        // Xóa sản phẩm khỏi chương trình khuyến mãi
        public function xoaSanPhamKhuyenMai($khuyenmai_id, $mathang_id) {
            $db = DATABASE::connect();
            try {
                $sql = "DELETE FROM mathang_khuyenmai 
                        WHERE khuyenmai_id = :khuyenmai_id AND mathang_id = :mathang_id";
                $cmd = $db->prepare($sql);
                $cmd->bindValue(':khuyenmai_id', $khuyenmai_id);
                $cmd->bindValue(':mathang_id', $mathang_id);
                return $cmd->execute();
            } catch (PDOException $e) {
                echo "<p>Lỗi khi xóa sản phẩm khuyến mãi: {$e->getMessage()}</p>";
                return false;
            }
        }
        public function xoaTatCaSanPhamTrongKhuyenMai($khuyenmai_id) {
             $db = DATABASE::connect(); 
             try {
                $sql = "DELETE FROM mathang_khuyenmai WHERE khuyenmai_id = :khuyenmai_id"; 
                $cmd = $db->prepare($sql);
                $cmd->bindValue(':khuyenmai_id', $khuyenmai_id, PDO::PARAM_INT);
                  return $cmd->execute();
                } catch (PDOException $e) {
                    echo "<p>Lỗi: {$e->getMessage()}</p>";
                    return false; 
                }
            }
    }

    ?>