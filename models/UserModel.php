<?php 
class UserModel {
    public $conn;
    public function __construct() {
        $this->conn= connectDB();
    }

    function getUser($emailUser, $passWord) {
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
    public function checkMail($email){
        $sql = "SELECT * FROM users WHERE email=:email";
        $stmt  = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    //hàm thêm account
    public function register($fullname, $email, $password,$phone, $address){
        $sql="INSERT INTO users (fullname, email, password, phone, address) VALUES (:fullname, :email, :password, :phone, :address)";
        $stmt =$this->conn->prepare($sql);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
       return $stmt->execute();
        
    }

    //hàm check user theo fullname và email
    public function checkUserForPasswordReset($fullname, $email, $phone){
        $sql="SELECT * FROM users WHERE fullname=:fullname AND email=:email AND phone=:phone";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(":fullname",$fullname);
        $stmt->bindParam(":email",$email);
        $stmt->bindParam(":phone",$phone);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }
    //hàm cập nhật pass cho người dùng thay mật khẩu mới khi quên
    public function updatePassword($email, $hashedNewPassword){
        $sql="UPDATE users SET email=:email, password=:password WHERE email=:email";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(":email",$email);
        $stmt->bindParam(":password",$hashedNewPassword);
        $stmt->execute();

    }
}

  

?>