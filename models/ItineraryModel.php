<?php 
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class ItineraryModel 
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllItineraries()
    {
        $sql = "SELECT * FROM `itineraries`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItineraryById($id)
    {
        $sql = "SELECT * FROM `itineraries` WHERE `id` = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addItinerary($data)
    {
        $sql = "INSERT INTO `itineraries` (`tour_id`, `day_number`, `title`, `activities`, `notes`) VALUES (:tour_id, :day_number, :title, :activities, :notes)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    public function editItinerary($data)
    {
        $sql = "UPDATE `itineraries` SET `tour_id` = :tour_id, `day_number` = :day_number, `title` = :title, `activities` = :activities, `notes` = :notes WHERE `id` = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    public function deleteItinerary($id)
    {
        $sql = "DELETE FROM `itineraries` WHERE `id` = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }   
}
