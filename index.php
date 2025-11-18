<?php 
session_start();
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/UsersController.php';
require_once './controllers/TourController.php';
require_once './controllers/ScheduleController.php';
require_once './controllers/AssignmentController.php';
// Require toàn bộ file Models
require_once './models/UserModel.php';
require_once './models/TourModel.php';
require_once './models/ScheduleModel.php';
// Route
$act = $_GET['act'] ?? '/';




// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    '/' => $_SERVER['REQUEST_METHOD']=='POST' ? (new UsersController())->formlogin() : (new UsersController())->Login(),

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
    
    // Dashboard hiển thị tour
    'home' => (new TourController())->Home(),

    // Quản lý tour
    'listTours' => (new TourController())->listTours(),

    'addTourForm' => (new TourController())->addTourForm(),

    'editTourForm' => (new TourController())->editTourForm($_GET['id'] ?? 0),

    'deleteTour' => (new TourController())->deleteTour($_GET['id'] ?? 0),

    // Quản lý lịch trình
    'listSchedule' => (new ScheduleController())->listSchedule(),
    // Quản lý phân công hướng dẫn viên
    'listAssignments' => (new AssignmentController())->index(),
    'createAssignment' => (new AssignmentController())->create(),
    'storeAssignment' => (new AssignmentController())->store(),
    'editAssignment' => (new AssignmentController())->edit(),
    'updateAssignment' => (new AssignmentController())->update(),
    'deleteAssignment' => (new AssignmentController())->delete(),

    // Mặc định: hiển thị trang login (tránh UnhandledMatchError)
    default => (new UsersController())->Login(),
};