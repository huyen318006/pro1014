<?php 
 class RollcallModel {
    public $conn;
    

    public function __construct()
    {
       $this->conn= connectDB();
    }


    //hàm lấy thông tin dựa theo id của depature_id dựa  vào bảng booking để lấy  
    public function Getboking($departureId) { 
        $sql= "SELECT customer_name, customer_phone,departure_id,id,  quantity, note
              FROM bookings
              WHERE departure_id = :id;";
              $stmt= $this->conn->prepare($sql);
              $stmt->bindParam(':id',$departureId);
              $stmt->execute();
              return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function saveCall($departure_id, $booking_id, $present, $absent, $late, $note = null)
    {
        $sql = "INSERT INTO rollcall_checklist 
            (departure_id, booking_id, present, absent, late, note, status, checked_at) 
        VALUES (:departure_id, :booking_id, :present, :absent, :late, :note, 0, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':departure_id', $departure_id, PDO::PARAM_INT);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->bindParam(':present', $present, PDO::PARAM_INT);
        $stmt->bindParam(':absent', $absent, PDO::PARAM_INT);
        $stmt->bindParam(':late', $late, PDO::PARAM_INT);
        $stmt->bindParam(':note', $note, PDO::PARAM_STR);

        return $stmt->execute();
    }
}

?>