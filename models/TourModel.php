<?php 
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class TourModel 
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllTours()
    {
        $sql = "SELECT tours.*, categories.name as category_name 
                FROM `tours` 
                LEFT JOIN `categories` ON tours.category_id = categories.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   
    public function getTourById($id)
    {
        $sql = "SELECT tours.*, 
                       categories.name as category_name, 
                       GROUP_CONCAT(DISTINCT policies.policy_type SEPARATOR ', ') as policy_type 
                FROM `tours` 
                LEFT JOIN `categories` ON tours.category_id = categories.id 
                LEFT JOIN `policies` ON tours.id = policies.tour_id
                WHERE tours.id = :id
                GROUP BY tours.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function addTour($code, $name, $destination, $category_id, $status, $price, $duration_days, $image)
    {
        $sql = "INSERT INTO tours (code, name, destination, category_id, status, price, duration_days, image) 
            VALUES ('$code', '$name', '$destination', '$category_id', '$status', '$price', '$duration_days', '$image')";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }
    public function updateTour($id, $code, $name, $destination, $category_id, $status, $price, $duration_days, $image)
    {
        $sql = "UPDATE `tours` SET code = '$code', name = '$name', destination = '$destination', category_id = '$category_id', status = '$status', price = '$price', duration_days = '$duration_days', image = '$image' WHERE id = '$id'";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }
    public function deleteTour($id)
    {
        $sql = "DELETE FROM `tours` WHERE id = '$id'";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }
}
