<?php

class Policy
{
    private $conn;

    public function __construct()
    {
        // Lấy kết nối PDO từ file config
        global $conn;
        $this->conn = $conn;
    }

    // ===========================
    // LẤY TẤT CẢ POLICIES + TÊN TOUR
    // ===========================
    public function getAllPolicies()
    {
        $sql = "SELECT p.*, t.name AS tour_name
                FROM policies p
                LEFT JOIN tours t ON p.tour_id = t.id
                ORDER BY p.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // ===========================
    // LẤY 1 POLICY THEO ID
    // ===========================
    public function getPolicyById($id)
    {
        $sql = "SELECT * FROM policies WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    // ===========================
    // TẠO MỚI CHÍNH SÁCH
    // ===========================
    public function createPolicy($tour_id, $policy_type, $content)
    {
        $sql = "INSERT INTO policies (tour_id, policy_type, content)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$tour_id, $policy_type, $content]);
    }

    // ===========================
    // CẬP NHẬT CHÍNH SÁCH
    // ===========================
    public function updatePolicy($id, $tour_id, $policy_type, $content)
    {
        $sql = "UPDATE policies 
                SET tour_id = ?, policy_type = ?, content = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$tour_id, $policy_type, $content, $id]);
    }

    // ===========================
    // XÓA CHÍNH SÁCH
    // ===========================
    public function deletePolicy($id)
    {
        $sql = "DELETE FROM policies WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$id]);
    }
}
