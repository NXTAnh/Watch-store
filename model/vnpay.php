<?php
class VNPAY {
    // Lưu thông tin giao dịch VNPay, liên kết với donhang_id (khóa ngoại)
    public function luuGiaoDich($amount, $bankcode, $banktranno, $cardtype, $orderinfo, $paydate, $tmncode, $transactionno, $donhang_id) {
        $db = DATABASE::connect();
        if ($db === null) return false;

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            $sql = "INSERT INTO vnpay (
                        amount, bankcode, banktranno, cardtype,
                        orderinfo, paydate, tmncode, transactionno, donhang_id
                    ) VALUES (
                        :amount, :bankcode, :banktranno, :cardtype,
                        :orderinfo, :paydate, :tmncode, :transactionno, :donhang_id
                    )";
            $cmd = $db->prepare($sql);

            $amount = (int)$amount;
            $donhang_id = (int)$donhang_id;

            $cmd->bindValue(':amount', $amount, PDO::PARAM_INT);
            $cmd->bindValue(':bankcode', $bankcode, PDO::PARAM_STR);
            $cmd->bindValue(':banktranno', $banktranno, PDO::PARAM_STR);
            $cmd->bindValue(':cardtype', $cardtype, PDO::PARAM_STR);
            $cmd->bindValue(':orderinfo', $orderinfo, PDO::PARAM_STR);
            $cmd->bindValue(':paydate', $paydate, PDO::PARAM_STR);
            $cmd->bindValue(':tmncode', $tmncode, PDO::PARAM_STR);
            $cmd->bindValue(':transactionno', $transactionno, PDO::PARAM_STR);
            $cmd->bindValue(':donhang_id', $donhang_id, PDO::PARAM_INT);

            $cmd->execute();
            return true;  // Lưu thành công
        } catch (PDOException $e) {
            error_log("Lỗi lưu giao dịch VNPay: " . $e->getMessage());
            echo "Lỗi lưu giao dịch VNPay: " . $e->getMessage();
            return false;
        }
    }

    // Cập nhật trạng thái đơn hàng (vd: 1 = đã thanh toán)
    public function capNhatTrangThaiDonHang($donhang_id, $trangthai) {
        $db = DATABASE::connect();
        if ($db === null) return false;

        try {
            $sql = "UPDATE donhang SET trangthai = :trangthai WHERE id = :donhang_id";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(':trangthai', $trangthai, PDO::PARAM_INT);
            $cmd->bindValue(':donhang_id', $donhang_id, PDO::PARAM_INT);
            return $cmd->execute();
        } catch (PDOException $e) {
            error_log("Lỗi cập nhật trạng thái đơn hàng: " . $e->getMessage());
            echo "Lỗi cập nhật trạng thái đơn hàng: " . $e->getMessage();
            return false;
        }
    }
}
