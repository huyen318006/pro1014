<?php
class StatisticsModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // 1. Tổng quan
    public function getSummaryStats()
    {
        $sql = "
            SELECT
                (SELECT COUNT(*) FROM tours) AS total_tours,
                (SELECT COUNT(*) FROM departures) AS total_departures,
                (SELECT COUNT(*) FROM bookings) AS total_bookings,
                (SELECT IFNULL(SUM(quantity), 0) FROM bookings) AS total_customers,
                (
                    SELECT IFNULL(SUM(b.quantity * t.price), 0)
                    FROM bookings b
                    JOIN departures d ON b.departure_id = d.id
                    JOIN tours t ON d.tour_id = t.id
                ) AS total_revenue
        ";

        return $this->conn->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    // 2. Doanh thu theo tour
    public function getRevenueByTour()
    {
        $sql = "
            SELECT t.name AS tour_name,
                   IFNULL(SUM(b.quantity * t.price), 0) AS total_revenue
            FROM tours t
            LEFT JOIN departures d ON t.id = d.tour_id
            LEFT JOIN bookings b ON b.departure_id = d.id
            GROUP BY t.id
            ORDER BY total_revenue DESC
        ";

        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Số khách theo tour
    public function getCustomerCountByTour()
    {
        $sql = "
            SELECT t.name AS tour_name,
                   IFNULL(SUM(b.quantity), 0) AS total_customers
            FROM tours t
            LEFT JOIN departures d ON t.id = d.tour_id
            LEFT JOIN bookings b ON b.departure_id = d.id
            GROUP BY t.id
            ORDER BY total_customers DESC
        ";

        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. Khách theo tháng
    public function getCustomerByMonth()
    {
        $sql = "
            SELECT DATE_FORMAT(created_at, '%Y-%m') AS month,
                   SUM(quantity) AS total_customers
            FROM bookings
            GROUP BY month
            ORDER BY month ASC
        ";

        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. Doanh thu theo tháng
    public function getRevenueByMonth()
    {
        $sql = "
            SELECT DATE_FORMAT(b.created_at, '%Y-%m') AS month,
                   SUM(b.quantity * t.price) AS total_revenue
            FROM bookings b
            JOIN departures d ON b.departure_id = d.id
            JOIN tours t ON d.tour_id = t.id
            GROUP BY month
            ORDER BY month ASC
        ";

        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTourDetail($id)
    {
        $sql = "
            SELECT t.*, 
                COUNT(DISTINCT d.id) AS total_departures,
                IFNULL(SUM(b.quantity), 0) AS total_customers,
                IFNULL(SUM(b.quantity * t.price), 0) AS total_revenue
            FROM tours t
            LEFT JOIN departures d ON t.id = d.tour_id
            LEFT JOIN bookings b ON b.departure_id = d.id
            WHERE t.id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
