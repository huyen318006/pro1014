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
        $sql = "SELECT t.id AS tour_id,
                       t.name AS tour_name,
                       t.code AS tour_code,
                       t.image AS tour_image,
                       COUNT(i.id) AS itinerary_count,
                       EXISTS (
                           SELECT 1 FROM departures d 
                           WHERE d.tour_id = t.id AND d.status = 'ready'
                       ) AS has_ready_departure
                FROM `tours` t
                INNER JOIN `itineraries` i ON t.id = i.tour_id
                GROUP BY t.id, t.name, t.code, t.image
                ORDER BY t.id DESC";
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

    public function getItinerariesByTourId($tourId)
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
                WHERE i.tour_id = :tour_id
                ORDER BY i.day_number ASC, i.title ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tour_id', $tourId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function checkDuplicateDay($tourId, $title, $excludeId = null)
    {
        if ($excludeId !== null) {
            // For edit: check if title exists in the same tour, excluding the current itinerary
            $sql = "SELECT COUNT(*) FROM `itineraries` WHERE `tour_id` = :tour_id AND `title` = :title AND `id` != :exclude_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':tour_id', $tourId, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':exclude_id', $excludeId, PDO::PARAM_INT);
        } else {
            // For add: check if title exists in the same tour
            $sql = "SELECT COUNT(*) FROM `itineraries` WHERE `tour_id` = :tour_id AND `title` = :title";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':tour_id', $tourId, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchColumn() > 0;
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
