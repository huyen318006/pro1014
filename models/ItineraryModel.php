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

    /**
     * Lấy lịch trình theo departure_id (cho guide)
     * Bao gồm thông tin checkpoint nếu có guide_id
     */
    public function getItinerariesByDepartureId($departureId, $guideId = null)
    {
        if ($guideId !== null) {
            // Lấy lịch trình kèm trạng thái checkpoint
            $sql = "SELECT i.*, 
                           t.name AS tour_name,
                           t.code AS tour_code,
                           t.image AS tour_image,
                           t.duration_days AS tour_duration,
                           d.departure_date,
                           d.meeting_point,
                           ic.checked_at,
                           ic.notes AS checkpoint_notes,
                           IF(ic.id IS NOT NULL, 1, 0) AS is_checked
                    FROM `itineraries` i
                    INNER JOIN `departures` d ON i.tour_id = d.tour_id
                    LEFT JOIN `tours` t ON i.tour_id = t.id
                    LEFT JOIN `itinerary_checkpoints` ic ON ic.itinerary_id = i.id 
                        AND ic.departure_id = :departure_id 
                        AND ic.guide_id = :guide_id
                    WHERE d.id = :departure_id
                    ORDER BY i.day_number ASC, i.title ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':departure_id', $departureId, PDO::PARAM_INT);
            $stmt->bindParam(':guide_id', $guideId, PDO::PARAM_INT);
        } else {
            // Lấy lịch trình không có checkpoint
            $sql = "SELECT i.*, 
                           t.name AS tour_name,
                           t.code AS tour_code,
                           t.image AS tour_image,
                           t.duration_days AS tour_duration,
                           d.departure_date,
                           d.meeting_point
                    FROM `itineraries` i
                    INNER JOIN `departures` d ON i.tour_id = d.tour_id
                    LEFT JOIN `tours` t ON i.tour_id = t.id
                    WHERE d.id = :departure_id
                    ORDER BY i.day_number ASC, i.title ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':departure_id', $departureId, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tính toán và lấy lịch trình của ngày hiện tại
     */
    public function getTodayItinerary($departureId, $currentDate)
    {
        $sql = "SELECT i.*, 
                       t.name AS tour_name,
                       d.departure_date,
                       DATEDIFF(:current_date, d.departure_date) + 1 AS current_day_number
                FROM `itineraries` i
                INNER JOIN `departures` d ON i.tour_id = d.tour_id
                LEFT JOIN `tours` t ON i.tour_id = t.id
                WHERE d.id = :departure_id
                  AND i.day_number = (DATEDIFF(:current_date, d.departure_date) + 1)
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':departure_id', $departureId, PDO::PARAM_INT);
        $stmt->bindParam(':current_date', $currentDate, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy trạng thái checkpoint của guide cho một departure
     */
    public function getCheckpointStatus($departureId, $guideId)
    {
        $sql = "SELECT itinerary_id, checked_at, notes 
                FROM `itinerary_checkpoints`
                WHERE departure_id = :departure_id 
                  AND guide_id = :guide_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':departure_id', $departureId, PDO::PARAM_INT);
        $stmt->bindParam(':guide_id', $guideId, PDO::PARAM_INT);
        $stmt->execute();

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[$row['itinerary_id']] = [
                'checked_at' => $row['checked_at'],
                'notes' => $row['notes']
            ];
        }
        return $result;
    }

    /**
     * Đánh dấu checkpoint đã hoàn thành
     */
    public function markCheckpoint($departureId, $itineraryId, $guideId, $notes = null)
    {
        try {
            $checkedAt = date('Y-m-d H:i:s');

            $sql = "INSERT INTO `itinerary_checkpoints` 
                    (departure_id, itinerary_id, guide_id, checked_at, notes)
                    VALUES (:departure_id, :itinerary_id, :guide_id, :checked_at, :notes)
                    ON DUPLICATE KEY UPDATE 
                        checked_at = :checked_at,
                        notes = :notes";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':departure_id', $departureId, PDO::PARAM_INT);
            $stmt->bindParam(':itinerary_id', $itineraryId, PDO::PARAM_INT);
            $stmt->bindParam(':guide_id', $guideId, PDO::PARAM_INT);
            $stmt->bindParam(':checked_at', $checkedAt, PDO::PARAM_STR);
            $stmt->bindParam(':notes', $notes, PDO::PARAM_STR);

            $result = $stmt->execute();

            if ($result) {
                return ['success' => true, 'checked_at' => $checkedAt];
            }
            return ['success' => false, 'error' => 'Failed to mark checkpoint'];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Bỏ đánh dấu checkpoint
     */
    public function unmarkCheckpoint($departureId, $itineraryId, $guideId)
    {
        try {
            $sql = "DELETE FROM `itinerary_checkpoints` 
                    WHERE departure_id = :departure_id 
                      AND itinerary_id = :itinerary_id 
                      AND guide_id = :guide_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':departure_id', $departureId, PDO::PARAM_INT);
            $stmt->bindParam(':itinerary_id', $itineraryId, PDO::PARAM_INT);
            $stmt->bindParam(':guide_id', $guideId, PDO::PARAM_INT);

            $result = $stmt->execute();

            if ($result) {
                return ['success' => true];
            }
            return ['success' => false, 'error' => 'Failed to unmark checkpoint'];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
