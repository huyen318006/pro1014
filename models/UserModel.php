<?php
class UserModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    function getallUser()
    {
        $sql = "SELECT * FROM users ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $user;
    }

    //ham kiemr tra dang nhap
    function getUser($emailUser, $passWord)
    {
        $sql = "SELECT * FROM users WHERE email=:emailUser and password=:passWord";
        // gọi hàm connectDB để kết nối CSDL
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':emailUser', $emailUser);
        $stmt->bindParam(':passWord', $passWord);
        $stmt->execute();

        // Lấy một bản ghi và trả về
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    //Kiểm tra email có tồn tại không
    public function checkMail($email)
    {
        $sql = "SELECT * FROM users WHERE email=:email";
        $stmt  = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    //hàm thêm account
    public function register($fullname, $email, $password, $phone, $address)
    {
        $sql = "INSERT INTO users (fullname, email, password, phone, address) VALUES (:fullname, :email, :password, :phone, :address)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        return $stmt->execute();
    }

    //hàm check user theo fullname và email
    public function checkUserForPasswordReset($fullname, $email, $phone)
    {
        $sql = "SELECT * FROM users WHERE fullname=:fullname AND email=:email AND phone=:phone";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":fullname", $fullname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    //hàm cập nhật pass cho người dùng thay mật khẩu mới khi quên
    public function updatePassword($email, $newPassword)
    {
        $sql = "UPDATE users SET password=:password WHERE email=:email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $newPassword);
        $stmt->execute();
    }
    // Lấy tất cả phân công, JOIN để lấy thông tin guide và tour đầy đủ
    public function getAllAssignments()
    {
        $sql = "SELECT 
                    a.*, 
                    u.fullname AS guide_name, 
                    d.tour_id,
                    d.departure_date,
                    d.meeting_point,
                    d.max_participants,
                    d.note,
                    d.status AS departure_status,
                    t.name AS tour_name
                FROM assignments a
                JOIN users u ON a.guide_id = u.id
                JOIN departures d ON a.departure_id = d.id
                LEFT JOIN tours t ON d.tour_id = t.id
                ORDER BY a.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   public function getAssignmentsByGuide($guide_id)
{
    $sql = "SELECT a.id, d.tour_id, t.name AS tour_name, a.departure_id
            FROM assignments a
            JOIN departures d ON a.departure_id = d.id
            JOIN tours t ON d.tour_id = t.id
            WHERE a.guide_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$guide_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    // Lấy 1 phân công theo id
    public function getAssignmentById($id)
    {
        $sql = "SELECT * FROM assignments WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm phân công
    public function storeAssignment($data)
    {
        $sql = "INSERT INTO assignments (departure_id, guide_id, assigned_at,booking_id)
                VALUES (:departure_id, :guide_id, :assigned_at,:booking_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount();
    }

    // Cập nhật phân công
    public function updateAssignment($data)
    {
        $sql = "UPDATE assignments
                SET departure_id = :departure_id,
                    guide_id = :guide_id,
                    assigned_at = :assigned_at
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount();
    }

    // Xóa phân công
    public function deleteAssignment($id)
    {
        $sql = "DELETE FROM assignments WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }

    // Lấy danh sách guide
    public function getAllGuides()
    {
        $sql = "SELECT * FROM users WHERE role='guide'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách departures
    public function getAllDepartures()
{
    $sql = "SELECT d.id, d.departure_date, d.status, t.name AS tour_name
            FROM departures d
            JOIN tours t ON d.tour_id = t.id
            ORDER BY d.departure_date ASC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // Kiểm tra trùng lịch: guide đã được phân công cho departure này chưa
    public function checkDuplicate($guide_id, $departure_id)
    {
        $sql = "SELECT * FROM assignments 
                WHERE guide_id=:guide_id AND departure_id=:departure_id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':guide_id' => $guide_id, ':departure_id' => $departure_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái tour
    public function updateDepartureStatus($departure_id, $status)
    {
        $sql = "UPDATE departures SET status=:status WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':status' => $status, ':id' => $departure_id]);
        return $stmt->rowCount();
    }


    ///////////////////// phần phân quyền role cho account ////////////////
    public function lockUser($id)
    {
        $sql = "UPDATE users SET status = 0 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    //mở khóa tài khoản
    public function openUser($id)
    {
        $sql = "UPDATE users SET status = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
