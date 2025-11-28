<?php
class IncidentReportModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Thêm báo cáo
    public function insert($data)
    {
        $sql = "INSERT INTO incident_reports 
                (assignment_id, incident_date, description, severity, resolution, reported_at)
                VALUES (:assignment_id, :incident_date, :description, :severity, :resolution, :reported_at)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
    }

    // Lấy tất cả báo cáo với tên HDV
    public function getAll()
    {
        $sql = "SELECT ir.*, 
                       u.fullname AS guide_name, 
                       t.name AS tour_name
                FROM incident_reports ir
                LEFT JOIN assignments a ON ir.assignment_id = a.id
                LEFT JOIN users u ON a.guide_id = u.id
                LEFT JOIN departures d ON a.departure_id = d.id
                LEFT JOIN tours t ON d.tour_id = t.id
                ORDER BY ir.reported_at DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Xóa báo cáo
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM incident_reports WHERE id = ?");
        $stmt->execute([$id]);
    }
}
