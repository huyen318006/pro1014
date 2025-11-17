<?php 
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class ScheduleModel 
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Viết truy vấn danh sách sản phẩm 
    public function getAllSchedules()
    {
        $sql = "SELECT * FROM `itineraries`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
