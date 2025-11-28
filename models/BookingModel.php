<?php
class BookingModel {
    public $conn;
    public function __construct(){
        $this->conn= connectDB();

    }

    //thêm đặt booking
    public function addbooking($departure_id, $customer_email, $customer_name, $customer_phone, $quantity, $note){
        $sql= 'INSERT INTO bookings(departure_id, customer_email, customer_name, customer_phone, quantity, note, created_at) VALUES 
        (:departure_id, :customer_email, :customer_name, :customer_phone, :quantity, :note, NOW())';
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':departure_id', $departure_id, PDO::PARAM_INT);
        $stmt->bindParam(':customer_email', $customer_email, PDO::PARAM_STR);
        $stmt->bindParam(':customer_name', $customer_name, PDO::PARAM_STR);
        $stmt->bindParam(':customer_phone', $customer_phone, PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':note', $note, PDO::PARAM_STR);

        return $stmt->execute();
        

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
}
    
 ?>