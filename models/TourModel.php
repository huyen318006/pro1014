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

    // Lấy tất cả ảnh phụ của tour
    public function getTourImages($tourId)
    {
        $sql = "SELECT * FROM `tour_images` WHERE tour_id = :tour_id ORDER BY display_order ASC, id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tour_id', $tourId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm ảnh phụ cho tour
    public function addTourImage($tourId, $imagePath, $displayOrder = 0)
    {
        $sql = "INSERT INTO `tour_images` (tour_id, image_path, display_order) VALUES (:tour_id, :image_path, :display_order)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tour_id', $tourId, PDO::PARAM_INT);
        $stmt->bindParam(':image_path', $imagePath, PDO::PARAM_STR);
        $stmt->bindParam(':display_order', $displayOrder, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Xóa ảnh phụ
    public function deleteTourImage($imageId)
    {
        $sql = "DELETE FROM `tour_images` WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $imageId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Cập nhật mô tả tour
    public function updateTourDescription($tourId, $description)
    {
        $sql = "UPDATE `tours` SET description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':id', $tourId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Kiểm tra mã tour đã tồn tại chưa
    public function checkDuplicateTourCode($code, $excludeId = null)
    {
        if ($excludeId) {
            // Khi sửa tour - loại trừ chính tour đang sửa
            $sql = "SELECT COUNT(*) FROM `tours` WHERE code = :code AND id != :exclude_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':code', $code, PDO::PARAM_STR);
            $stmt->bindParam(':exclude_id', $excludeId, PDO::PARAM_INT);
        } else {
            // Khi thêm mới
            $sql = "SELECT COUNT(*) FROM `tours` WHERE code = :code";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
