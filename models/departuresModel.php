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
    //Hiển thị tất cả  các lịch khởi hành
    public function getAllDepartures(){
        $sql = "SELECT  departures.*, tours.name AS tour_name, tours.price AS tour_price,  tours.duration_days AS duration_days
         FROM departures
         JOIN tours ON  tours.id = departures.tour_id";
    
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    //truy van departures của phần gudie
       public function getByDepartures($departures_id){
        $sql = "SELECT  departures.*, tours.name AS tour_name, tours.price AS tour_price, users.fullname AS guide_name, tours.duration_days AS duration_days, assignments.id AS assignments_id
         FROM departures
         JOIN tours ON  tours.id = departures.tour_id
         JOIN assignments ON departures.id = assignments.departure_id
         JOIN users ON assignments.guide_id = users.id
            WHERE departures.id= :departures_id"
       ;
        $stmt = $this->conn->prepare($sql);
          $stmt->bindParam(':departures_id',$departures_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    

    //update departure
    public function getBydeparture($departures_id){
        $sql = "SELECT  departures.*
        FROM departures
            WHERE departures.id= :departures_id"
       ;
        $stmt = $this->conn->prepare($sql);
          $stmt->bindParam(':departures_id',$departures_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  
    }
  public function Updatedeparture($departure_id,$tour_id,$departure_date,$max_participants,$note){
    // Chuẩn bị câu lệnh SQL
    $sql = "UPDATE departures 
            SET tour_id = :tour_id,
                departure_date = :departure_date,
                max_participants = :max_participants,
                note = :note
            WHERE id = :departure_id";

    // Chuẩn bị statement
    $stmt = $this->conn->prepare($sql);

    // Bind các tham số
    $stmt->bindParam(':tour_id', $tour_id, PDO::PARAM_INT);
    $stmt->bindParam(':departure_date', $departure_date, PDO::PARAM_STR);
    $stmt->bindParam(':max_participants', $max_participants, PDO::PARAM_INT);
    $stmt->bindParam(':note', $note, PDO::PARAM_STR);
    $stmt->bindParam(':departure_id', $departure_id, PDO::PARAM_INT);

    // Thực thi
    return $stmt->execute();
}

public function delete_DepartureAdmin($id_DepartureAdmin) {
    $sql= 'DELETE FROM departures WHERE id=:id';
    $stmt=$this->conn->prepare($sql);
    $stmt->bindParam(':id',$id_DepartureAdmin);
    return $stmt->execute();
}
//add form
public function addDeparture($tour_id, $departure_date, $meeting_point, $max_participants, $note){

  $sql= "INSERT INTO departures (tour_id,departure_date,max_participants,meeting_point,note) VALUES (:tour_id,:departure_date,:max_participants,:meeting_point,:note)";
  $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tour_id', $tour_id);

        $stmt->bindParam(':departure_date', $departure_date);
        $stmt->bindParam(':meeting_point', $meeting_point);
        $stmt->bindParam(':max_participants', $max_participants);
        $stmt->bindParam(':note', $note);
        return $stmt->execute();
    }

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