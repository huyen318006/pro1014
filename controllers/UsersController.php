<?php
// có class chứa các function thực thi xử lý logic 
class UsersController
{
    public $modelProduct;

    //tạo 1 biến để gọi model user
    public $modelUser;

    public function __construct() {
        //kết nối model user
        $this->modelUser = new UserModel();

    }

    



/////////////////////////////////////////     phần php của trang login      /////////////////////////////////////////
    public function Login(){
        require_once BASE_URL_VIEWS.'login/login.php';
    }

public function formlogin() {
    if(isset($_POST['login'])) {
        $emailUser = $_POST['email'];
        $passWord  = $_POST['password'];

        $user = $this->modelUser->getUser($emailUser, $passWord);

        if($user) {
            // Lưu TẤT CẢ user vào $_SESSION['user']
            $_SESSION['user'] = $user;

                // Chuyển hướng dựa vào role
                if ($user['status'] == 0) {
                    echo "<script>
            alert('Tài khoản đã bị khóa. Vui lòng liên hệ admin!');
            window.location.href = '" . BASE_URL . "';
          </script>";
                    exit();
                }


                if($user['role'] == 'admin') {
                $_SESSION['user'] = $user;
                header('Location: ' . BASE_URL . '?act=admin');
                exit();
            } elseif($user['role'] == 'guide') {
                $_SESSION['user'] = $user;
                header('Location: ' . BASE_URL . '?act=guide');
                exit();
            } else {
                // user thường
                header('Location: ' . BASE_URL);
                exit();
            }
        } else {
            // ĐĂNG NHẬP SAI → DÙNG HEADER + SESSION (không dùng JS nữa)
            $_SESSION['error'] = 'Sai email hoặc mật khẩu!';
            header('Location: ' . BASE_URL);   // về trang login chính (/)
            exit();
        }
    }
}


/////////////////////////////////////////        phần đăng kí       /////////////////////////////////////////
public function register(){
    require_once BASE_URL_VIEWS.'login/register.php';
}

// Sửa formregister()
public function formregister(){
    if(isset($_POST['register'])){
        $fullname = $_POST['fullname'];
        $email    = $_POST['email'];
        $phone    = $_POST['phone'];
        $address  = $_POST['address'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if($password !== $confirm_password){
            $_SESSION['error'] = 'Mật khẩu không khớp!';
            header('Location: ' . BASE_URL . '?act=register');
            exit();
        }

        if($this->modelUser->checkMail($email)){
            $_SESSION['error'] = 'Email đã tồn tại!';
            header('Location: ' . BASE_URL . '?act=register');
            exit();
        }

        // Lưu mật khẩu dạng plaintext (theo yêu cầu của bạn)
        $this->modelUser->register($fullname, $email, $password, $phone, $address);

        $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
        header('Location: ' . BASE_URL);   // về trang login chính
        exit();
    }
}

/////////////////////////////////////////        phần quên mật khẩu      /////////////////////////////////////////
public function forgotpass(){
    require_once BASE_URL_VIEWS.'login/forgotpass.php';
}
public function formforgotpassword() {
    if(isset($_POST['submit'])){
        $fullname = $_POST['fullname'];
        $email    = $_POST['email'];
        $phone    = $_POST['phone'];
        $newpassword = $_POST['newpassword'];
        $confirmpassword = $_POST['confirmpassword'];

        if ($newpassword !== $confirmpassword) {
            $_SESSION['error'] = 'Mật khẩu xác nhận không khớp!';
            header('Location: ' . BASE_URL . '?act=forgotpassword');
            exit();
        }

        $user = $this->modelUser->checkUserForPasswordReset($fullname, $email, $phone);
        if (!$user) {
            $_SESSION['error'] = 'Thông tin không đúng!';
            header('Location: ' . BASE_URL . '?act=forgotpassword');
            exit();
        }

        // Cập nhật mật khẩu mới (plaintext)
        $this->modelUser->updatePassword($email, $newpassword);

        $_SESSION['success'] = 'Đặt lại mật khẩu thành công!';
        header('Location: ' . BASE_URL);
        exit();
    }
}


//////////////////////////////////////////        phần đăng xuất      /////////////////////////////////////////
public function logout(){
    session_destroy();
    header("Location: " . BASE_URL); // về trang login chính, không cần ?act=login
    exit();
}


//////////////////////////////////////////        phần đăng qua trang admin     /////////////////////////////////////////
public function admin(){
    $tourController = new TourController(); // gọi class TourController
    $tourController->Home();
}

public function guide(){
    require_once BASE_URL_VIEWS.'guide/guide.php';
}


    ////////////////////////////   quản lí phần account bên admin//////////////
    public function account(){
        $users=$this->modelUser->getallUser();
        require_once BASE_URL_VIEWS.'admin/account/account.php';
    }
    public function change_role(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $id = $_POST['id'];
            $role = $_POST['role'];
            //gọi hàm phân quyền
            // Gọi hàm phân quyền trong model
            $this->modelUser->changeRole($id, $role);
            header('Location: ' . BASE_URL . '?act=account');
            exit;
        }
    }

    /// khóa tài khoản 
    function block_user()
    {
        if (isset($_GET['id'])) {
            //gọi hàm   cập nhật  trạng thái người dùng khóa nguời dùng
            $lockuser = $this->modelUser->lockUser($_GET['id']);
            header('Location: ' . BASE_URL . '?act=account');
            exit;
        }
    }
    public function open_user(){
        if (isset($_GET['id'])) {
            //gọi hàm   cập nhật  trạng thái người dùng khóa nguời dùng
            $lockuser = $this->modelUser->openUser($_GET['id']);
            header('Location: ' . BASE_URL . '?act=account');
            exit;
        }

    }
}
