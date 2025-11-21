<?php
class CategoryModel {
    public $conn; 

    public function __construct(){
        $this->conn = connectDB(); 
    }

    public function getCategories(){
        $sql = "SELECT * FROM `categories`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(); 
    }
    
}