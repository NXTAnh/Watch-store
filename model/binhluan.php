<?php
class BINHLUAN {
    public function thembinhluan($nguoidung_id, $mathang_id, $noidung) {
        $db = DATABASE::connect();
        if ($db === null) return;
    
        try {
            $sql = "INSERT INTO binhluan(nguoidung_id, mathang_id, noidung, ngay) 
                    VALUES(:nguoidung_id, :mathang_id, :noidung, NOW())";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(':nguoidung_id', $nguoidung_id);
            $cmd->bindValue(':mathang_id', $mathang_id);
            $cmd->bindValue(':noidung', $noidung);
            $cmd->execute();
        } catch (PDOException $e) {
            echo "<p>Lỗi bình luận: " . $e->getMessage() . "</p>";
        }
    }
    

    public function layBinhLuanTheoMatHang($mathang_id) {
        $db = DATABASE::connect();
        if ($db === null) return [];
    
        try {
            $sql = "SELECT bl.noidung, bl.ngay, nd.hoten 
                    FROM binhluan bl
                    JOIN nguoidung nd ON bl.nguoidung_id = nd.id
                    WHERE bl.mathang_id = :mathang_id
                    ORDER BY bl.ngay DESC";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(':mathang_id', $mathang_id);
            $cmd->execute();
            return $cmd->fetchAll();
        } catch (PDOException $e) {
            echo "<p>Lỗi truy vấn bình luận: " . $e->getMessage() . "</p>";
            return [];
        }
    }
    
}
