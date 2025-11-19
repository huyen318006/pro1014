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
    public function getAll()
    {
        $sql = "SELECT * FROM services ORDER BY id DESC";
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
    public function insert($name, $type, $price, $description)
    {
        $sql = "INSERT INTO services (name, type, price, description)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $type, $price, $description]);
    }

    // ================================
    // 4. Cập nhật dịch vụ
    // ================================
    public function update($id, $name, $type, $price, $description)
    {
        $sql = "UPDATE services 
                SET name = ?, type = ?, price = ?, description = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $type, $price, $description, $id]);
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

