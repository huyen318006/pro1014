<?php
class ChecklistModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB(); // Hàm kết nối DB
    }

    // Lấy checklist theo departure, kèm tên HDV
    public function getChecklistByDeparture($departureId) {
        $sql = "SELECT c.id, c.departure_id, c.item_name, c.is_checked, u.fullname AS checked_by_name
                FROM checklists c
                LEFT JOIN users u ON c.checked_by = u.id
                WHERE c.departure_id = ?
                ORDER BY c.id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$departureId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // HDV lưu checklist
    public function saveChecklist($departureId, $guideId, $checkedItems) {
        // Reset tất cả về chưa tick
        $sqlReset = "UPDATE checklists SET is_checked=0, checked_by=NULL WHERE departure_id=?";
        $this->conn->prepare($sqlReset)->execute([$departureId]);

        // Cập nhật các mục đã tick
        $sqlUpdate = "UPDATE checklists SET is_checked=1, checked_by=? WHERE departure_id=? AND item_name=?";
        $stmt = $this->conn->prepare($sqlUpdate);

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
            $stmtCheck = $this->conn->prepare($checkSql);
            $stmtCheck->execute([$departureId, $item]);
            if (!$stmtCheck->fetch()) {
                $insertSql = "INSERT INTO checklists (departure_id, item_name, is_checked, checked_by) VALUES (?, ?, 0, NULL)";
                $this->conn->prepare($insertSql)->execute([$departureId, $item]);
            }
        }
    }
    // Lấy thông tin tour theo departure_id
    public function getDepartureInfo($departureId) {
    $sql = "SELECT departures.id, departures.departure_date, tours.name AS tour_name
            FROM departures
            JOIN tours ON departures.tour_id = tours.id
            WHERE departures.id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$departureId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // ADMIN xem checklist kèm tên HDV + tên tour
public function getChecklistFullForAdmin($departureId) {
    $sql = "SELECT 
                c.*, 
                u.fullname AS guide_name,
                t.name AS tour_name,
                d.departure_date
            FROM checklists c
            LEFT JOIN users u ON c.checked_by = u.id
            LEFT JOIN departures d ON c.departure_id = d.id
            LEFT JOIN tours t ON d.tour_id = t.id
            WHERE c.departure_id = ?
            ORDER BY c.id ASC";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$departureId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
