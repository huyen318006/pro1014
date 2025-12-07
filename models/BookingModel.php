<?php
class BookingModel {
    public $conn;
    public function __construct(){
        $this->conn= connectDB();

    }


    //hiển thị trang chính của booking 
    public function getAllDepartures()
    {
        $sql = "SELECT 
                d.*,
                t.name AS tour_name,
                t.price AS tour_price,
                t.image AS image,
                t.duration_days AS duration_days
            FROM departures d
            JOIN tours t ON t.id = d.tour_id
            WHERE d.departure_date >= CURDATE()
              AND d.status = 'planned'
              AND d.max_participants > 0
            GROUP BY d.id
            ORDER BY d.departure_date ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //hàm lấy tour
    public function getAllTours(){
        $sql='SELECT * FROM tours';
        $stmt=$this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    //thêm đặt booking
    public function addbooking($departure_id, $customer_email, $customer_name, $customer_phone, $quantity, $note)
    {
        // Thêm booking
        $sql = 'INSERT INTO bookings(departure_id, customer_email, customer_name, customer_phone, quantity, note, created_at) 
            VALUES (:departure_id, :customer_email, :customer_name, :customer_phone, :quantity, :note, NOW())';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':departure_id', $departure_id, PDO::PARAM_INT);
        $stmt->bindParam(':customer_email', $customer_email, PDO::PARAM_STR);
        $stmt->bindParam(':customer_name', $customer_name, PDO::PARAM_STR);
        $stmt->bindParam(':customer_phone', $customer_phone, PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':note', $note, PDO::PARAM_STR);
        $stmt->execute();

        
    }

    /////////////////-----phần lấy cho bên assignment----------//////////////
    //lấy tất cả các booking 
    function getallbooking(){
        $sql= "SELECT bookings.*,
         departures.id AS id_departure,
        departures.departure_date as departure_date,
          departures.status AS departure_status,
           tours.name AS tour_name
           FROM bookings
        JOIN departures ON bookings.departure_id = departures.id
        JOIN tours ON departures.tour_id = tours.id
        WHERE departures.status = 'planned'
          ORDER BY bookings.id DESC

        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //lấy id của departure  trong bảng booking cho  phân công
    public function getBookingById($booking_id)
    {
        $sql = "SELECT * FROM bookings WHERE id = :booking_id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':booking_id' => $booking_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //phần  kiểm tra phân công trc khi đặt tour
    public function isGuideBusy($guide_id, $departure_date)
    {
        $sql = "SELECT d.*, b.guide_id 
            FROM departures d
            JOIN bookings b ON d.id = b.departure_id
            WHERE b.guide_id = :guide_id 
              AND d.departure_date = :departure_date";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':guide_id', $guide_id);
        $stmt->bindParam(':departure_date', $departure_date);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // trả về 1 bản ghi nếu có
    }

    // =============================
    // Lấy thông tin departure theo ID

    // =============================
    public function getById($departure_id)
    {
        $sql = "SELECT * FROM departures WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $departure_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    
}

    
 ?>