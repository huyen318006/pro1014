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
        $sql = "SELECT * FROM `tours`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   
    public function getTourById($id)
    {
        $sql = "SELECT * FROM `tours` WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function addTour($data)
    {
        $sql = 'INSERT INTO `tours` (id, code, name, destination, type, status, price, duration_days) 
                VALUES (:id, :code, :name, :destination, :type, :status, :price, :duration_days)';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
        
        return $stmt->rowCount();
    }

    public function updateTour($data)
    {
        $sql = "UPDATE `tours` 
                SET id = :id,
                    code = :code,
                    name = :name, 
                    destination = :destination,
                    type = :type,
                    status = :status,
                    price = :price, 
                    duration_days = :duration_days
                WHERE id = :original_id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    public function deleteTour($id)
    {
        $sql = "DELETE FROM `tours` WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
