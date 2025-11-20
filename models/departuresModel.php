<?php
class Departures {
    // Define properties and methods for the Departures model
    public $conn;

     public function __construct()
    {
        $this->conn = connectDB();
    }

    //truy vấn các TOUR của guide dựa vào guide_id
   public function getDeparturesByGuide($guide_id)
    {
    $sql= "SELECT departures.*, tours.name AS tour_name 
           FROM departures 
           JOIN assignments ON departures.id = assignments.departure_id 
           JOIN tours ON departures.tour_id = tours.id
           WHERE assignments.guide_id = :guide_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':guide_id', $guide_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllDepartures()
    {
        $sql = "SELECT  departures.*, tours.name AS tour_name, tours.price AS tour_price, users.fullname AS guide_name, tours.duration_days AS duration_days
         FROM departures
         JOIN tours ON  tours.id = departures.tour_id
         JOIN assignments ON departures.id = assignments.departure_id
         JOIN users ON assignments.guide_id = users.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
  
    // Trong models/Departures.php
    // Thay toàn bộ hàm getAllWithTourInfo() bằng đoạn này
    public function getAllWithTourInfo()
    {
        $sql = "SELECT 
                    d.*,
                    COALESCE(t.name, CONCAT('Tour ID: ', d.tour_id)) AS tour_name,
                    DATE_FORMAT(d.departure_date, '%d/%m/%Y') AS departure_date_formatted,
                    COALESCE(d.meeting_point, 'Chưa có điểm đón') AS meeting_point
                FROM departures d
                LEFT JOIN tours t ON d.tour_id = t.id
                ORDER BY d.departure_date DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>