<?php
class Services {

    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // ========================================
    // 1. LẤY TẤT CẢ DỊCH VỤ (không cần departure)
    // ========================================
    public function getAll()
    {
        $sql = "SELECT 
                    s.*,
                    t.name AS tour_name,
                    t.code AS tour_code
                FROM services s
                LEFT JOIN tours t ON s.tour_id = t.id
                ORDER BY s.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ========================================
    // 2. LẤY DỊCH VỤ THEO ID
    // ========================================
    public function getServiceById($id)
    {
        $sql = "SELECT 
                    s.*,
                    t.name AS tour_name,
                    t.code AS tour_code
                FROM services s
                LEFT JOIN tours t ON s.tour_id = t.id
                WHERE s.id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ========================================
    // 3. LẤY DỊCH VỤ THEO TOUR ID (CHUẨN 100%)
    // ========================================
    public function getByTourId($tour_id)
    {
        $sql = "SELECT 
                    s.*,
                    t.name AS tour_name,
                    t.code AS tour_code
                FROM services s
                JOIN tours t ON s.tour_id = t.id
                WHERE s.tour_id = ?
                ORDER BY s.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ========================================
    // 4. THÊM DỊCH VỤ THEO TOUR ID (KHÔNG departure)
    // ========================================
    public function createByTour($tour_id, $service_name, $partner_name, $status = 'pending', $note = null)
    {
        $allowed = ['pending', 'confirmed', 'cancelled'];
        $status = in_array($status, $allowed) ? $status : 'pending';

        $sql = "INSERT INTO services (tour_id, service_name, partner_name, status, note) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$tour_id, $service_name, $partner_name, $status, $note]);
    }

    // ========================================
    // 5. CẬP NHẬT DỊCH VỤ
    // ========================================
    public function update($id, $service_name, $partner_name, $status, $note)
    {
        $allowed = ['pending', 'confirmed', 'cancelled'];
        $status = in_array($status, $allowed) ? $status : 'pending';

        $sql = "UPDATE services 
                SET service_name = ?, 
                    partner_name = ?,
                    status = ?,
                    note = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$service_name, $partner_name, $status, $note, $id]);
    }

    // ========================================
    // 6. XÓA DỊCH VỤ
    // ========================================
    public function delete($id)
    {
        $sql = "DELETE FROM services WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
