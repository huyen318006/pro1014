<?php
class Journals {
    private $db;

    public function __construct() {
        $this->db = connectDB(); // kết nối DB
    }

    // Lấy danh sách nhật ký của guide
    public function getJournalsByGuide($guide_id) {
        $sql = "
            SELECT j.*, t.name as tour_name, d.departure_date, b.customer_name
            FROM journals j
            JOIN assignments a ON j.assignment_id = a.id
            JOIN departures d ON a.departure_id = d.id
            JOIN tours t ON d.tour_id = t.id
            LEFT JOIN bookings b ON a.booking_id = b.id
            WHERE a.guide_id = ?
            ORDER BY j.journal_date DESC, j.journal_time DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$guide_id]);
        return $stmt->fetchAll();
    }

    // Lấy danh sách phân công của guide để viết nhật ký
    public function getAssignmentsForJournal($guide_id) {
        $sql = "
            SELECT a.id as assignment_id, t.name as tour_name, d.departure_date, b.customer_name
            FROM assignments a
            JOIN departures d ON a.departure_id = d.id
            JOIN tours t ON d.tour_id = t.id
            LEFT JOIN bookings b ON a.booking_id = b.id
            WHERE a.guide_id = ?
            ORDER BY d.departure_date DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$guide_id]);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM journals WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO journals (
            assignment_id, guide_id, journal_date, journal_time, title, content,
            location, incident, extra_cost, photos, sent_to_admin, created_at, updated_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['assignment_id'],
            $data['guide_id'],
            $data['journal_date'],
            $data['journal_time'],
            $data['title'],
            $data['content'],
            $data['location'] ?? null,
            $data['incident'] ?? null,
            $data['extra_cost'] ?? 0,
            $data['photos'] ?? null,
            $data['sent_to_admin'] ?? 0
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE journals SET
            journal_date = ?, journal_time = ?, title = ?, content = ?,
            location = ?, incident = ?, extra_cost = ?, photos = ?,
            sent_to_admin = ?, updated_at = NOW()
            WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['journal_date'],
            $data['journal_time'],
            $data['title'],
            $data['content'],
            $data['location'] ?? null,
            $data['incident'] ?? null,
            $data['extra_cost'] ?? 0,
            $data['photos'] ?? null,
            $data['sent_to_admin'] ?? 0,
            $id
        ]);
    }

    public function delete($id) {
        // Xóa ảnh trước
        $journal = $this->getById($id);
        if ($journal && $journal['photos']) {
            $photos = json_decode($journal['photos'], true);
            if (is_array($photos)) {
                foreach ($photos as $photo) {
                    deleteFile($photo);
                }
            }
        }

        $sql = "DELETE FROM journals WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Lấy tất cả nhật ký cho admin
public function getAllJournalsForAdmin() {
    $sql = "
        SELECT j.*, u.fullname as guide_name, t.name as tour_name, d.departure_date, b.customer_name
        FROM journals j
        JOIN assignments a ON j.assignment_id = a.id
        JOIN users u ON a.guide_id = u.id
        JOIN departures d ON a.departure_id = d.id
        JOIN tours t ON d.tour_id = t.id
        LEFT JOIN bookings b ON a.booking_id = b.id
        ORDER BY j.journal_date DESC, j.journal_time DESC
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Lấy chi tiết một nhật ký cho admin
public function getByIdForAdmin($id) {
    $sql = "
        SELECT j.*, u.fullname as guide_name, t.name as tour_name, d.departure_date, b.customer_name
        FROM journals j
        JOIN assignments a ON j.assignment_id = a.id
        JOIN users u ON a.guide_id = u.id
        JOIN departures d ON a.departure_id = d.id
        JOIN tours t ON d.tour_id = t.id
        LEFT JOIN bookings b ON a.booking_id = b.id
        WHERE j.id = ?
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

}
