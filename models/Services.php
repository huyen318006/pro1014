<?php
class Services {

    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // ================================
    // 1. Lấy tất cả dịch vụ
    // ================================
    // models/Services.php → HÀM getAll() – ĐÃ FIX HOÀN TOÀN (copy đè nguyên hàm này)
    public function getAll() {
        $sql = "SELECT 
                    s.*,
                    COALESCE(t.name, CONCAT('Tour ID: ', d.tour_id)) AS tour_name,
                    DATE_FORMAT(d.departure_date, '%d/%m/%Y') AS departure_date_formatted,
                    COALESCE(d.meeting_point, 'Chưa có điểm đón') AS meeting_point
                FROM services s
                LEFT JOIN departures d ON s.departure_id = d.id
                LEFT JOIN tours t ON d.tour_id = t.id
                ORDER BY s.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // ================================
    // 2. Lấy dịch vụ theo ID
    // ================================
    public function getServiceById($id)
    {
        $sql = "SELECT * FROM services WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================================
    // 3. Thêm dịch vụ
    // ================================
    public function create($departure_id, $service_name, $partner_name, $status, $note = null)
{
    // Chỉ chấp nhận các giá trị hợp lệ
    $allowed = ['pending', 'confirmed', 'cancelled'];
    $status = in_array($status, $allowed) ? $status : 'pending';

    $sql = "INSERT INTO services 
            (departure_id, service_name, partner_name, status, note) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
        $departure_id,
        $service_name,
        $partner_name,
        $status,
        $note
    ]);
}

    // ================================
    // 4. Cập nhật dịch vụ
    // ================================
   public function update($id, $departure_id, $service_name, $partner_name, $status, $note = null)
    {
        // BẮT BUỘC PHẢI CÓ DÒNG NÀY – FIX LỖI "Data truncated for column 'status'"
        $allowed = ['pending', 'confirmed', 'cancelled'];
        $status = in_array($status, $allowed) ? $status : 'pending';

        $sql = "UPDATE services 
                SET departure_id = ?, 
                    service_name = ?, 
                    partner_name = ?, 
                    status = ?, 
                    note = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $departure_id,
            $service_name,
            $partner_name,
            $status,     // ← giờ đã an toàn 100%
            $note,
            $id
        ]);
    }

    // ================================
    // 5. Xóa dịch vụ
    // ================================
    public function delete($id)
    {
        // Xóa service trong bảng trung gian trước
        $sql = "DELETE FROM departure_services WHERE service_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        // Xóa dịch vụ chính
        $sql = "DELETE FROM services WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    // ================================
    // 6. Lấy danh sách service của 1 departure
    // ================================
    public function getServicesByDeparture($departure_id)
    {
        $sql = "SELECT s.*
                FROM services s
                JOIN departure_services ds ON s.id = ds.service_id
                WHERE ds.departure_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$departure_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================================
    // 7. Gắn dịch vụ vào departure
    // ================================
    public function addServiceToDeparture($departure_id, $service_id)
    {
        $sql = "INSERT INTO departure_services (departure_id, service_id)
                VALUES (?, ?)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$departure_id, $service_id]);
    }

    // ================================
    // 8. Xóa dịch vụ khỏi departure
    // ================================
    public function removeServiceFromDeparture($departure_id, $service_id)
    {
        $sql = "DELETE FROM departure_services
                WHERE departure_id = ? AND service_id = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$departure_id, $service_id]);
    }

}
?>

