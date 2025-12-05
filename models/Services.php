<?php
class Services {

    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // 1. LẤY TẤT CẢ DỊCH VỤ (dùng cho trang danh sách khi không lọc)
    public function getAll()
    {
        $sql = "SELECT 
                    s.*,
                    d.departure_date,
                    DATE_FORMAT(d.departure_date, '%d/%m/%Y') AS departure_date_formatted,
                    t.name AS tour_name,
                    t.code AS tour_code
                FROM services s
                LEFT JOIN departures d ON s.departure_id = d.id
                LEFT JOIN tours t ON d.tour_id = t.id
                ORDER BY s.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. LẤY DỊCH VỤ THEO ID
    public function getServiceById($id)
    {
        $sql = "SELECT s.*, d.tour_id, d.departure_date, t.name AS tour_name 
                FROM services s
                LEFT JOIN departures d ON s.departure_id = d.id
                LEFT JOIN tours t ON d.tour_id = t.id
                WHERE s.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3. HÀM QUAN TRỌNG: LẤY DỊCH VỤ THEO TOUR_ID (ĐÃ SỬA ĐÚNG 100%)
    public function getServicesByTour($tour_id)
    {
        $sql = "SELECT 
                    s.*,
                    d.departure_date,
                    DATE_FORMAT(d.departure_date, '%d/%m/%Y') AS departure_date_formatted
                FROM services s
                JOIN departures d ON s.departure_id = d.id
                WHERE d.tour_id = ?
                ORDER BY d.departure_date DESC, s.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. LẤY DỊCH VỤ THEO DEPARTURE_ID
    public function getServicesByDeparture($departure_id)
    {
        $sql = "SELECT * FROM services WHERE departure_id = ? ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$departure_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. THÊM DỊCH VỤ
    public function create($departure_id, $service_name, $partner_name, $status = 'pending', $note = null)
    {
        $allowed = ['pending', 'confirmed', 'cancelled'];
        $status = in_array($status, $allowed) ? $status : 'pending';

        $sql = "INSERT INTO services (departure_id, service_name, partner_name, status, note) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$departure_id, $service_name, $partner_name, $status, $note]);
    }

    // 6. CẬP NHẬT DỊCH VỤ
    public function update($id, $service_name, $partner_name) {
    $sql = "UPDATE services 
            SET service_name = ?, 
                partner_name = ?
            WHERE id = ?";

    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$service_name, $partner_name, $id]);
}
    public function delete($id) {
    $sql = "DELETE FROM services WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$id]);
}
}
?>