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
            // Lấy lịch trình kèm trạng thái checkpoint cho từng activity
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
            $stmt->execute();
            $itineraries = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Lấy tất cả checkpoints cho departure này
            $checkpointSql = "SELECT itinerary_id, activity_index, checked_at, notes 
                             FROM `itinerary_checkpoints`
                             WHERE departure_id = :departure_id AND guide_id = :guide_id";
            $checkpointStmt = $this->conn->prepare($checkpointSql);
            $checkpointStmt->bindParam(':departure_id', $departureId, PDO::PARAM_INT);
            $checkpointStmt->bindParam(':guide_id', $guideId, PDO::PARAM_INT);
            $checkpointStmt->execute();
            $checkpoints = $checkpointStmt->fetchAll(PDO::FETCH_ASSOC);

            // Gắn checkpoints vào itineraries
            foreach ($itineraries as &$itinerary) {
                $itinerary['activity_checkpoints'] = [];
                foreach ($checkpoints as $checkpoint) {
                    if ($checkpoint['itinerary_id'] == $itinerary['id']) {
                        $itinerary['activity_checkpoints'][$checkpoint['activity_index']] = [
                            'checked_at' => $checkpoint['checked_at'],
                            'notes' => $checkpoint['notes']
                        ];
                    }
                }
            }

            return $itineraries;
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
     * @param int $activityIndex - Index của activity (0 = cả ngày, 1+ = activity cụ thể)
     */
    public function markCheckpoint($departureId, $itineraryId, $guideId, $activityIndex = 0, $notes = null)
    {
        try {
            $checkedAt = date('Y-m-d H:i:s');

            $sql = "INSERT INTO `itinerary_checkpoints` 
                    (departure_id, itinerary_id, guide_id, activity_index, checked_at, notes)
                    VALUES (:departure_id, :itinerary_id, :guide_id, :activity_index, :checked_at, :notes)
                    ON DUPLICATE KEY UPDATE 
                        checked_at = :checked_at,
                        notes = :notes";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':departure_id', $departureId, PDO::PARAM_INT);
            $stmt->bindParam(':itinerary_id', $itineraryId, PDO::PARAM_INT);
            $stmt->bindParam(':guide_id', $guideId, PDO::PARAM_INT);
            $stmt->bindParam(':activity_index', $activityIndex, PDO::PARAM_INT);
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
     * @param int $activityIndex - Index của activity (0 = cả ngày, 1+ = activity cụ thể)
     */
    public function unmarkCheckpoint($departureId, $itineraryId, $guideId, $activityIndex = 0)
    {
        try {
            $sql = "DELETE FROM `itinerary_checkpoints` 
                    WHERE departure_id = :departure_id 
                      AND itinerary_id = :itinerary_id 
                      AND guide_id = :guide_id
                      AND activity_index = :activity_index";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':departure_id', $departureId, PDO::PARAM_INT);
            $stmt->bindParam(':itinerary_id', $itineraryId, PDO::PARAM_INT);
            $stmt->bindParam(':guide_id', $guideId, PDO::PARAM_INT);
            $stmt->bindParam(':activity_index', $activityIndex, PDO::PARAM_INT);

            $result = $stmt->execute();

            if ($result) {
                return ['success' => true];
            }
            return ['success' => false, 'error' => 'Failed to unmark checkpoint'];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Lấy danh sách HDV đã được phân công cho tour
     */
    public function getAssignedGuidesByTourId($tourId)
    {
        $sql = "SELECT DISTINCT 
                    u.id,
                    u.fullname,
                    u.email,
                    u.phone,
                    d.departure_date,
                    d.status AS departure_status,
                    a.assigned_at
                FROM `assignments` a
                INNER JOIN `users` u ON a.guide_id = u.id
                INNER JOIN `departures` d ON a.departure_id = d.id
                WHERE d.tour_id = :tour_id
                  AND u.role = 'guide'
                ORDER BY d.departure_date DESC, a.assigned_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tour_id', $tourId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Admin: Lấy tất cả checkpoints của HDV cho một departure
     */
    public function getCheckpointsForAdmin($departureId)
    {
        // Lấy thông tin departure và tour
        $sql = "SELECT d.*, t.name AS tour_name, t.code AS tour_code
                FROM `departures` d
                LEFT JOIN `tours` t ON d.tour_id = t.id
                WHERE d.id = :departure_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':departure_id', $departureId, PDO::PARAM_INT);
        $stmt->execute();
        $departureInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        // Lấy lịch trình
        $itineraries = $this->getItinerariesByTourId($departureInfo['tour_id']);

        // Lấy tất cả checkpoints của departure này (tất cả HDV)
        $checkpointSql = "SELECT ic.*, u.fullname AS guide_name, i.title AS itinerary_title, i.day_number
                         FROM `itinerary_checkpoints` ic
                         INNER JOIN `users` u ON ic.guide_id = u.id
                         INNER JOIN `itineraries` i ON ic.itinerary_id = i.id
                         WHERE ic.departure_id = :departure_id
                         ORDER BY u.id, i.day_number, ic.activity_index";
        $checkpointStmt = $this->conn->prepare($checkpointSql);
        $checkpointStmt->bindParam(':departure_id', $departureId, PDO::PARAM_INT);
        $checkpointStmt->execute();
        $checkpoints = $checkpointStmt->fetchAll(PDO::FETCH_ASSOC);

        // Nhóm checkpoints theo guide
        $checkpointsByGuide = [];
        foreach ($checkpoints as $checkpoint) {
            $guideId = $checkpoint['guide_id'];
            if (!isset($checkpointsByGuide[$guideId])) {
                $checkpointsByGuide[$guideId] = [
                    'guide_name' => $checkpoint['guide_name'],
                    'checkpoints' => []
                ];
            }
            $checkpointsByGuide[$guideId]['checkpoints'][] = $checkpoint;
        }

        return [
            'departure_info' => $departureInfo,
            'itineraries' => $itineraries,
            'checkpoints_by_guide' => $checkpointsByGuide
        ];
    }

    /**
     * Admin: Lấy chi tiết checkpoint của một HDV cụ thể cho departure
     */
    public function getGuideCheckpointDetails($departureId, $guideId)
    {
        // Lấy thông tin departure và tour
        $sql = "SELECT d.*, t.name AS tour_name, t.code AS tour_code, t.duration_days,
                       u.fullname AS guide_name, u.email AS guide_email, u.phone AS guide_phone
                FROM `departures` d
                LEFT JOIN `tours` t ON d.tour_id = t.id
                LEFT JOIN `assignments` a ON d.id = a.departure_id
                LEFT JOIN `users` u ON a.guide_id = u.id
                WHERE d.id = :departure_id AND u.id = :guide_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':departure_id', $departureId, PDO::PARAM_INT);
        $stmt->bindParam(':guide_id', $guideId, PDO::PARAM_INT);
        $stmt->execute();
        $info = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$info) {
            return null;
        }

        // Lấy lịch trình với checkpoints của HDV này
        $itineraries = $this->getItinerariesByDepartureId($departureId, $guideId);

        // Tính thống kê
        $totalActivities = 0;
        $completedActivities = 0;

        foreach ($itineraries as &$itinerary) {
            $activities = array_filter(array_map('trim', explode("\n", $itinerary['activities'] ?? '')));
            $totalActivities += count($activities);
            
            $activityCheckpoints = $itinerary['activity_checkpoints'] ?? [];
            foreach ($activityCheckpoints as $idx => $checkpoint) {
                if ($idx > 0) { // Skip index 0 (whole day marker)
                    $completedActivities++;
                }
            }
        }

        return [
            'info' => $info,
            'itineraries' => $itineraries,
            'total_activities' => $totalActivities,
            'completed_activities' => $completedActivities,
            'progress_percent' => $totalActivities > 0 ? round(($completedActivities / $totalActivities) * 100) : 0
        ];
    }
}
