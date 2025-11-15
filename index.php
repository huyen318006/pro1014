<?php 
session_start();
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/UsersController.php';

// Require toàn bộ file Models
require_once './models/ProductModel.php';
require_once './models/UserModel.php';

// Route
$act = $_GET['act'] ?? '/';


// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    '/' => (new UsersController())->Login(),

    // Xử lý đăng nhập
    'formlogin' => (new UsersController())->formlogin(),
    //xử lý đăng kí
    'register' => (new UsersController())->register(),
    'formregister' => (new UsersController())->formregister(),
    'logout' => (new UsersController())->logout(),

    //xử lí quên mật khẩu
    'forgotpassword' => (new UsersController())->forgotpass(),
    'formforgotpassword' => (new UsersController())->formforgotpassword(),
    
 

    // Redirects from controller can point here; map to Login for now
    'admin' => (new UsersController())->admin(),
    'guide' => (new UsersController())->guide(),

    // Mặc định: hiển thị trang login (tránh UnhandledMatchError)
    default => (new UsersController())->Login(),
};