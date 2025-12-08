<?php
class Departures {
    // Define properties and methods for the Departures model
    public $conn;

     public function __construct()
    {
        $this->conn = connectDB();
    }

    //truy vấn các TOUR của guide dựa vào guide_id(hiển thị bên phần quản trị của guide)
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
    public function getAllDepartures()
    {
        $sql = "SELECT 
                departures.*, 
                tours.name AS tour_name, 
                tours.price AS tour_price,
                tours.duration_days AS duration_days,
                tours.image AS image,
                users.fullname AS guide_name
            FROM departures
            JOIN tours ON tours.id = departures.tour_id
            LEFT JOIN assignments ON assignments.departure_id = departures.id
            LEFT JOIN users ON users.id = assignments.guide_id";

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
public function addDeparture($tour_id, $departure_date, $meeting_point, $max_participants, $note, $guide_id) {

  $sql= "INSERT INTO departures (tour_id,departure_date,max_participants,meeting_point,note) VALUES (:tour_id,:departure_date,:max_participants,:meeting_point,:note)";
  $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tour_id', $tour_id);

        $stmt->bindParam(':departure_date', $departure_date);
        $stmt->bindParam(':meeting_point', $meeting_point);
        $stmt->bindParam(':max_participants', $max_participants);
        $stmt->bindParam(':note', $note);
        $stmt->execute();
        // Lấy ID của departure vừa thêm
        $departure_id = $this->conn->lastInsertId();

        // Thêm vào bảng assignments
        $sqlAssign = "INSERT INTO assignments (departure_id, guide_id) VALUES (:departure_id, :guide_id)";
        $stmtAssign = $this->conn->prepare($sqlAssign);
        $stmtAssign->bindParam(':departure_id', $departure_id);
        $stmtAssign->bindParam(':guide_id', $guide_id);
        $stmtAssign->execute();
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

    ////////////////////////--------------phần model lấy cho booking controller-------////////////////////

    public function departureandbooking($id) {
        $sql = "SELECT departures.*, tours.name AS tour_name, tours.price as tour_price, tours.image as tour_image
        FROM departures inner join tours on departures.tour_id=tours.id  
        WHERE departures.id=:id
        ";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }




    
    //cập nhật số ghế khi mà đã đặt xong  booking
    public function updateSeats($departure_id, $quantity_booked)
    {
        // Lấy số vé còn hiện tại
        $sql = "SELECT max_participants FROM departures WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $departure_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $newSeats = $row['max_participants'] - $quantity_booked;

            if ($newSeats < 0) {
                $newSeats = 0; // tránh số âm
            }

            // Cập nhật số vé còn lại
            $sqlUpdate = "UPDATE departures SET max_participants = :newSeats WHERE id = :id";
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            $stmtUpdate->execute([
                ':newSeats' => $newSeats,
                ':id' => $departure_id
            ]);
        }
    }


    // Lấy tất cả lịch khởi hành theo ngày để kiểm tra trùng
    public function getByTourAndDate($tour_id, $departure_date)
    {
        $sql = "SELECT * FROM departures WHERE tour_id = :tour_id AND departure_date = :departure_date";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tour_id', $tour_id);
        $stmt->bindParam(':departure_date', $departure_date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

  
   
// Kiểm tra guide có đang được phân công tour nào không
public function isGuideAssigned($guide_id) {
    $sql = "SELECT COUNT(*) as count FROM assignments WHERE guide_id = :guide_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':guide_id', $guide_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;

    //đến đây là đã kiểm tra bản ghi dựa theo id của guide nếu có trả về true ko có trả về false
}

// Kiểm tra guide có đang đi tour (departure_date <= hôm nay) không
public function isGuideOnActiveTour($guide_id) {
    $sql = "SELECT COUNT(*) as count 
            FROM assignments a
            JOIN departures d ON a.departure_id = d.id
            WHERE a.guide_id = :guide_id 
            AND d.departure_date <= CURDATE()";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':guide_id', $guide_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;
}

// Lấy chi tiết tour mà guide đang được phân công
public function getGuideAssignedTours($guide_id) {
    $sql = "SELECT d.*, t.name as tour_name, a.id as assignment_id
            FROM assignments a
            JOIN departures d ON a.departure_id = d.id
            JOIN tours t ON d.tour_id = t.id
            WHERE a.guide_id = :guide_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':guide_id', $guide_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

        // Kiểm tra guide có rảnh để nhận phân công cho khoảng thời gian bắt đầu từ $start_date
        // và kéo dài $duration_days (số ngày). Trả về true nếu không có xung đột,
        // ngược lại trả về false.
        public function isGuideAvailable($guide_id, $start_date, $duration_days = 1)
        {
            // Tính ngày kết thúc đề xuất
            $daysToAdd = max(0, intval($duration_days) - 1);
            $proposed_start = date('Y-m-d', strtotime($start_date));
            $proposed_end = date('Y-m-d', strtotime($proposed_start . " +{$daysToAdd} days"));

            $sql = "SELECT COUNT(*) as cnt
                    FROM assignments a
                    JOIN departures d ON a.departure_id = d.id
                    JOIN tours t ON d.tour_id = t.id
                    WHERE a.guide_id = :guide_id
                      AND NOT (
                          :proposed_end < d.departure_date
                          OR :proposed_start > DATE_ADD(d.departure_date, INTERVAL (t.duration_days - 1) DAY)
                      )";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':guide_id', $guide_id, PDO::PARAM_INT);
            $stmt->bindParam(':proposed_start', $proposed_start);
            $stmt->bindParam(':proposed_end', $proposed_end);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return ($row && intval($row['cnt']) === 0);
        }




}
?>