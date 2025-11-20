<?php
class ChecklistModel {
    private $connection;

    public function __construct() {
        $this->connection = connectDB(); // Hàm kết nối DB
    }

    // Lấy checklist theo departure, kèm tên HDV
    public function getChecklistByDeparture($departureId) {
        $sql = "SELECT c.id, c.departure_id, c.item_name, c.is_checked, u.fullname AS checked_by_name
                FROM checklists c
                LEFT JOIN users u ON c.checked_by = u.id
                WHERE c.departure_id = ?
                ORDER BY c.id ASC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$departureId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // HDV lưu checklist
    public function saveChecklist($departureId, $guideId, $checkedItems) {
        // Reset tất cả về chưa tick
        $sqlReset = "UPDATE checklists SET is_checked=0, checked_by=NULL WHERE departure_id=?";
        $this->connection->prepare($sqlReset)->execute([$departureId]);

        // Cập nhật các mục đã tick
        $sqlUpdate = "UPDATE checklists SET is_checked=1, checked_by=? WHERE departure_id=? AND item_name=?";
        $stmt = $this->connection->prepare($sqlUpdate);

        foreach ($checkedItems as $item) {
            $stmt->execute([$guideId, $departureId, $item]);
        }
    }

    // Tạo checklist mẫu cho departure mới (nếu cần)
    public function createDefaultChecklist($departureId) {
        $defaultItems = ['Chuẩn bị vé tham quan', 'Kiểm tra xe du lịch', 'Chuẩn bị bảng tên đoàn'];
        foreach ($defaultItems as $item) {
            // Kiểm tra trùng
            $checkSql = "SELECT 1 FROM checklists WHERE departure_id=? AND item_name=?";
            $stmtCheck = $this->connection->prepare($checkSql);
            $stmtCheck->execute([$departureId, $item]);
            if (!$stmtCheck->fetch()) {
                $insertSql = "INSERT INTO checklists (departure_id, item_name, is_checked, checked_by) VALUES (?, ?, 0, NULL)";
                $this->connection->prepare($insertSql)->execute([$departureId, $item]);
            }
        }
    }
}
