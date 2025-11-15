<?php
// có class chứa các function thực thi xử lý logic 
class UsersController
{
    public $modelProduct;

    //tạo 1 biến để gọi model user
    public $modelUser;

    public function __construct() {
        $this->modelProduct = new ProductModel();
        //kết nối model user
        $this->modelUser = new UserModel();

    }

    



/////////////////////////////////////////     phần php của trang login      /////////////////////////////////////////
    public function Login(){
        require_once BASE_URL_VIEWS.'login/login.php';
    }

public function formlogin() {
    if(isset($_POST['login'])) {
        $emailUser= $_POST['email'];
        $passWord= $_POST['password'];

        // Lấy user trong DB
        $user= $this->modelUser->getUser($emailUser, $passWord);

        if($user) {
            // kiểm tra quyền admin hoặc guide
            if($user['role']=='admin') {
                $_SESSION['admin'] = $user;
                header('Location: '.BASE_URL.'?act=admin'); 
                exit();

            } else if($user['role']=='guide') {
                $_SESSION['guide'] = $user;
                header('Location: '.BASE_URL.'?act=guide');
                exit();
            }
        } 
        else {
            // ---------------------------
            // THÔNG BÁO LỖI ĐĂNG NHẬP SAI
            // ---------------------------
            echo "<script>alert('Sai email hoặc mật khẩu!'); window.location='".BASE_URL."?act=login';</script>";
            exit();
        }
    }
}


/////////////////////////////////////////        phần đăng kí       /////////////////////////////////////////
public function register(){
    require_once BASE_URL_VIEWS.'login/register.php';
}

public function formregister(){
    if(isset($_POST['register'])){
        $fullname=$_POST['fullname'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $address=$_POST['address'];
        $password=$_POST['password'];
        $confirm_password=$_POST['confirm_password'];
        $existingUser = $this->modelUser->checkMail($email);
        if($password!==$confirm_password){
            echo "<script>alert('Mật khẩu không khớp, vui lòng nhập lại!'); window.location='".BASE_URL."?act=register';</script>";
            exit();
        }
        //kiểm tra email đã tồn tại chưa
        
        if($existingUser){
            echo "<script>alert('Email đã tồn tại, vui lòng sử dụng email khác!'); window.location='".BASE_URL."?act=register';</script>";
            exit();
        }

        // Nếu không có lỗi, tiến hành đăng ký
          //vì là bảo mật 
           //dùng password_hash() là hàm của PHP dùng để mã hoá mật khẩu trước khi lưu vào cơ sở dữ liệu
           //PASSWORD_DEFAULT là thuật toán mã hoá mặc định của PHP (hiện tại là bcrypt)
       
        $this->modelUser->register($fullname, $email, $password, $phone, $address);
        echo "<script>alert('Đăng ký thành công! Vui lòng đăng nhập.'); window.location='".BASE_URL."?act=login';</script>";
        exit();
    }

}


/////////////////////////////////////////        phần quên mật khẩu      /////////////////////////////////////////
public function forgotpass(){
    require_once BASE_URL_VIEWS.'login/forgotpass.php';
}
function formforgotpassword() {
    if(isset($_POST['submit'])){
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $newpassword = $_POST['newpassword'];
        $confirmpassword = $_POST['confirmpassword'];

        // Kiểm tra mật khẩu mới và xác nhận mật khẩu có khớp không
        if ($newpassword !== $confirmpassword) {
            echo "<script>alert('Mật khẩu mới và xác nhận mật khẩu không khớp!'); window.location='".BASE_URL."?act=forgotpassword';</script>";
            exit();
        }

        // Kiểm tra thông tin người dùng trong cơ sở dữ liệu
        $user = $this->modelUser->checkUserForPasswordReset($fullname, $email, $phone);
        if (!$user) {
            echo "<script>alert('Thông tin không hợp lệ hoặc tài khoản không tồn tại!'); window.location='".BASE_URL."?act=forgotpassword';</script>";
            exit();
        }

        // Cập nhật mật khẩu mới (mã hóa trước khi lưu)
        $hashedNewPassword = password_hash($newpassword, PASSWORD_DEFAULT);
        $this->modelUser->updatePassword($email, $hashedNewPassword);

        echo "<script>alert('Mật khẩu đã được đặt lại thành công! Vui lòng đăng nhập với mật khẩu mới.'); window.location='".BASE_URL."?act=login';</script>";
        exit();
    }

}


//////////////////////////////////////////        phần đăng xuất      /////////////////////////////////////////
public function logout(){
    session_start();
    session_destroy();
    header("Location: " . BASE_URL . "?act=login");
    exit();
}



//////////////////////////////////////////        phần đăng qua trang admin     /////////////////////////////////////////
public function admin(){
    require_once BASE_URL_VIEWS.'trangchu.php';


}

public function guide(){
    require_once BASE_URL_VIEWS.'guide/guide.php';
}
}
