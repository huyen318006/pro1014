<?php 
class policy
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllPolicies()
    {
        $sql = "SELECT policies.*, tours.name as tour_name 
                FROM `policies` 
                LEFT JOIN `tours` ON policies.tour_id = tours.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPolicyById($id)
    {
        $sql = "SELECT policies.*, tours.name as tour_name 
                FROM `policies` 
                LEFT JOIN `tours` ON policies.tour_id = tours.id
                WHERE policies.id = '$id'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPolicy($tour_id, $policy_type, $content)
    {
        $sql = "INSERT INTO policies (tour_id, policy_type, content) 
                VALUES ('$tour_id', '$policy_type', '$content')";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }

    public function updatePolicy($id, $tour_id, $policy_type, $content)
    {
        $sql = "UPDATE policies 
                SET tour_id = '$tour_id', policy_type = '$policy_type', content = '$content'
                WHERE id = '$id'";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }

    public function deletePolicy($id)
    {
        $sql = "DELETE FROM policies WHERE id = '$id'";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }
}
