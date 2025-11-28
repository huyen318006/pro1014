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
        $sql = "SELECT i.*, 
                       t.name AS tour_name,
                       t.code AS tour_code,
                       t.image AS tour_image,
                       EXISTS (
                           SELECT 1 FROM departures d 
                           WHERE d.tour_id = i.tour_id AND d.status = 'ready'
                       ) AS has_ready_departure
                FROM `itineraries` i
                LEFT JOIN `tours` t ON i.tour_id = t.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItineraryById($id)
    {
        $sql = "SELECT i.*, 
                       t.name AS tour_name,
                       t.code AS tour_code,
                       t.image AS tour_image,
                       EXISTS (
                           SELECT 1 FROM departures d 
                           WHERE d.tour_id = i.tour_id AND d.status = 'ready'
                       ) AS has_ready_departure
                FROM `itineraries` i
                LEFT JOIN `tours` t ON i.tour_id = t.id
                WHERE i.`id` = :id
                LIMIT 1";
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

    public function hasReadyDeparture($tourId)
    {
        $sql = "SELECT COUNT(*) FROM departures WHERE tour_id = :tour_id AND status = 'ready'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tour_id', $tourId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
