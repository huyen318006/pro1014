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
    
    public function editSchedule($data)
    {
        $sql = "UPDATE `itineraries` SET `tour_id` = :tour_id, `day_number` = :day_number, `title` = :title, `activities` = :activities, `notes` = :notes WHERE `id` = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    public function deleteSchedule($data)
    {
        $sql = "DELETE FROM `itineraries` WHERE `id` = :id AND `tour_id` = :tour_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
}
