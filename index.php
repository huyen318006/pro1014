<?php
session_start();
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/UsersController.php';
require_once './controllers/TourController.php';
require_once './controllers/ItineraryController.php';
require_once './controllers/GuideController.php';
require_once './controllers/AssignmentController.php';
require_once './controllers/ServicesController.php';
require_once './controllers/DepartureController.php';
require_once './controllers/ChecklistController.php';
require_once './controllers/IncidentReportController.php';
require_once './controllers/PolicyController.php';

// Require toàn bộ file Models
require_once './models/UserModel.php';
require_once './models/TourModel.php';
require_once './models/ItineraryModel.php';
require_once './models/departuresModel.php';
require_once "models/services.php";
require_once './models/ChecklistModel.php';
require_once './models/IncidentReportModel.php';
require_once './models/CategoryModel.php';
require_once './models/PolicyModel.php';
// Route
$act = $_GET['act'] ?? '/';




// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    '/' => $_SERVER['REQUEST_METHOD'] == 'POST' ? (new UsersController())->formlogin() : (new UsersController())->Login(),

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

    'detailTour' => (new TourController())->detailTour($_GET['id'] ?? 0),

    'addTourForm' => (new TourController())->addTourForm(),

    'editTourForm' => (new TourController())->editTourForm($_GET['id'] ?? 0),

    'deleteTour' => (new TourController())->deleteTour($_GET['id'] ?? 0),

    // Quản lý lịch trình
    'listItinerary' => (new ItineraryController())->listItinerary(),

    'addItineraryForm' => (new ItineraryController())->addItinerary(),

    'editItinerary' => (new ItineraryController())->editItinerary($_GET['id'] ?? 0),

    'deleteItinerary' => (new ItineraryController())->deleteItinerary($_GET['id'] ?? 0),

    // Quản lý phân công hướng dẫn viên
    'listAssignments' => (new AssignmentController())->index(),
    'createAssignment' => (new AssignmentController())->create(),
    'storeAssignment' => (new AssignmentController())->store(),
    'editAssignment' => (new AssignmentController())->edit(),
    'updateAssignment' => (new AssignmentController())->update(),
    'deleteAssignment' => (new AssignmentController())->delete(),

    //phần quản lí lịch trình tour của admin dành cho nhân viên
    'DepartureAdmin' => (new DepartureController())->DepartureAdmin(),
  //edit kịch trình tour
  'editDepartureAdmin'=>(new DepartureController())->editDepartureAdmin(),
      //cập nhật  lịch khởi hành 
      'updateDeparture'=>(new DepartureController()) -> updateDeparture(),
  'deleteDepartureAdmin'=> (new DepartureController())->deleteDepartureAdmin(),
  //add  addDepartureAdmin
  'addDepartureAdmin'=> (new DepartureController())->addDepartureAdmin(),
  //fomr thêm lịch
  'addDepartureForm'=>(new DepartureController()) ->addDepartureForm(),

    //Quản lí dịch vụ
    'services' => (new ServicesController())->index(),
    'servicesCreate' => (new ServicesController())->create(),
    'servicesStore' => (new ServicesController())->store(),
    'servicesEdit' => (new ServicesController())->edit(),
    'servicesUpdate' => (new ServicesController())->update(),
    'servicesDelete' => (new ServicesController())->delete(),


          ////////////Phần quản lí tài khoản////////////
                'account'=>(new UsersController())->account(),
                //phân quyền cho các tài khoản guide
                'change_role'=>(new UsersController())->change_role(),
                //khóa tài khoản user
                'block_user'=>(new UsersController())->block_user(),
                //mở khóa tài khoản
                'open_user'=> (new UsersController())->open_user(),
    //checklist cho admin và guide
    'showChecklistForGuide' => (new ChecklistController())->showChecklistForGuide(),
    'saveChecklistForGuide' => (new ChecklistController())->saveChecklistForGuide(),
    'showChecklistForAdmin' => (new ChecklistController())->showChecklistForAdmin(),
    //báo cáo sự cố của admin và guide
    // Guide tạo báo cáo
    'incident' => (new IncidentReportController())->create(),

    // Admin danh sách báo cáo
    'incidents' => (new IncidentReportController())->index(),

    // Xóa báo cáo (không phân quyền)
    'incidentReportsDelete' => (new IncidentReportController())->delete(),





    //bắt đầu routr của guide
      //TRANG DASHBOARD CỦA GUIDE
      'guideDashboard' => (new GuideController())->guideDashboard(),
      //trang lịch khởi hành của guide
      'guideDepartures' => (new GuideController())->guideDepartures(),
      //TRANG TOUR ĐƯỢC GIAO CỦA GUIDE
      'MyTour' => (new GuideController())->MyTour(),
      //Về phần status 
      'updateStatus' => (new AssignmentController())->updateStatus(),
    // Mặc định: hiển thị trang login (tránh UnhandledMatchError)
    default => (new UsersController())->Login(),
};
